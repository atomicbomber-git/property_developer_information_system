import React,  {Component, Fragment} from 'react'
import ReactDOM from 'react-dom'
import InputFormControl from './InputFormControl'
import {get, keyBy} from 'lodash'
import axios from 'axios'
import { numberFormat, currencyFormat } from '../helpers/number'

class UpdateDeliveryOrderPricesForm extends React.Component {
    constructor(props) {
        super(props)

        this.keyCounter = 0

        this.state = {
            delivery_order_items: {},
            errorData: {}
        }

        this.onFormSubmit = this.onFormSubmit.bind(this)
        this.mapStateToFormData = this.mapStateToFormData.bind(this)
    }

    mapStateToFormData() {
        return {
            delivery_order_items: keyBy(Object.keys(this.state.delivery_order_items).map(key => {
                let do_items = this.state.delivery_order_items
                return {id: do_items[key].id, price: do_items[key].price}
            }), 'id')
        }
    }

    componentDidMount() {
        axios.get(window.location.href)
            .then(response => {
                this.setState({ delivery_order_items: keyBy(response.data, 'id') })
            })
            .catch();
    }

    onFormSubmit(e) {
        e.preventDefault();

        axios.post(window.location.href, this.mapStateToFormData())
            .then(response => { if (response.data.redirect) { window.location.replace(response.data.redirect); } })
            .catch(error => {
                this.setState({ errorData: error.response.data })
            })
    }

    render() {
        return (
            <form onSubmit={this.onFormSubmit}>
                <div className="table-responsive">
                    <table className="table table-sm table-striped">
                        <thead className="thead-dark">
                            <tr>
                                <th> # </th>
                                <th> Item </th>
                                <th className="text-right"> Quantity </th>
                                <th> Unit </th>
                                <th className='text-right'> Price </th>
                                <th className='text-right'> Subtotal </th>
                            </tr>
                        </thead>

                        <tbody>
                            {Object.keys(this.state.delivery_order_items).map((key, i) => {
                                let do_items = this.state.delivery_order_items;
                                return(
                                    <tr key={i}>
                                        <td> {i + 1}. </td>
                                        <td> {do_items[key].item.name} </td>
                                        <td className="text-right"> {numberFormat(do_items[key].quantity)} </td>
                                        <td> {do_items[key].item.unit} </td>
                                        <td className='text-right'>
                                            <InputFormControl
                                                className={{'form-control-sm': true, 'text-right': true}}
                                                type='number'
                                                step='any'
                                                placeholder='Price'
                                                isInvalid={get(this.state.errorData, ['errors', `delivery_order_items.${key}.price`, 0], false)}
                                                invalidFeedback={get(this.state.errorData, ['errors', `delivery_order_items.${key}.price`, 0], '')}
                                                value={parseFloat(do_items[key].price)}
                                                onChange={(e) => {
                                                    let newPrice = e.target.value
                                                    this.setState(prevState => {
                                                        let updated = {}
                                                        updated[key] = {...do_items[key], price: newPrice}
                                                        return {delivery_order_items: {...prevState.delivery_order_items, ...updated}}
                                                    })
                                                }}
                                                />
                                            <button type="button" onClick={(e) => {
                                                    let copied = {...this.state.delivery_order_items};
                                                    copied[key] = {...do_items[key], price: do_items[key].latest_price}

                                                    this.setState({
                                                        delivery_order_items: copied
                                                    })
                                                }}

                                                className="btn btn-dark btn-sm d-inline-block mt-1">
                                                Use Latest Price: {currencyFormat(do_items[key].latest_price)}
                                            </button>
                                        </td>
                                        <td className='text-right'>
                                            {currencyFormat(do_items[key].price * do_items[key].quantity)}
                                        </td>
                                    </tr>
                                )
                            })}
                        </tbody>
                    </table>
                    </div>

                <div className="text-right">
                    <button className="btn btn-primary btn-sm">
                        Update
                        <i className="fa fa-check"></i>
                    </button>
                </div>
            </form>

        )
    }
}

const rootElem = document.getElementById('update-delivery-order-prices-form')
if (rootElem) {
    ReactDOM.render(<UpdateDeliveryOrderPricesForm/>, rootElem)
}
