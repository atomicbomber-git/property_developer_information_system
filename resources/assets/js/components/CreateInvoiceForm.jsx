import React, {Component} from 'react'
import ReactDOM from 'react-dom'
import InputFormControl from './InputFormControl'
import classNames from 'classnames'
import {get} from 'lodash'

class CreateInvoiceForm extends Component  {
    constructor(props) {
        super(props)

        this.urls = {
            unbilled_vendors: `/vendor/api/unbilled`,
            unbilled_delivery_orders: vendor_id => `/vendor/api/unbilled_delivery_orders/${vendor_id}`,
            invoice_creation: `/invoice/create`
        }

        this.state = {
            received_at: '',
            number: '',
            vendor_options: [],
            selected_vendor_option: '',
            delivery_order_options: [],
            error_data: {}
        }

        this.onVendorSelectionChange = this.onVendorSelectionChange.bind(this)
        this.loadUnbilledDeliveryOrders = this.loadUnbilledDeliveryOrders.bind(this)
        this.onSelectDeliveryOrder = this.onSelectDeliveryOrder.bind(this)
        this.onFormSubmit = this.onFormSubmit.bind(this)
        this.getFormData = this.getFormData.bind(this)
    }

    getFormData() {
        return {
            received_at: this.state.received_at,
            number: this.state.number,
            vendor_id: this.state.selected_vendor_option,
            delivery_orders: this.state.delivery_order_options
                .filter(delivery_order => delivery_order.is_selected)
                .map(delivery_order => delivery_order.id)
        }
    }

    loadUnbilledDeliveryOrders(vendorId) {
        axios.get(this.urls.unbilled_delivery_orders(vendorId))
            .then(response => {

                let delivery_orders = response.data.map(delivery_order => {
                    return {...delivery_order, is_selected: false}
                })

                this.setState({
                    delivery_order_options: delivery_orders
                })
            })
            .catch(error => {
                console.log(error)
            })
    }

    onVendorSelectionChange(e) {
        this.setState({ selected_vendor_option: e.target.value })
        
        axios.get(this.urls.unbilled_delivery_orders(e.target.value))
            .then(response => {
                let delivery_orders = response.data.map(delivery_order => {
                    return {...delivery_order, is_selected: false}
                })

                this.setState({
                    delivery_order_options: delivery_orders
                })
            })
            .catch(error => {
                console.log(error)
            })
    }

    onSelectDeliveryOrder(delivery_order_id) {
        let updated = this.state.delivery_order_options.map(delivery_order => {
            if (delivery_order.id == delivery_order_id) {
                return {...delivery_order, is_selected: !delivery_order.is_selected}
            }
            return delivery_order
        })

        this.setState({ delivery_order_options: updated })
    }

    componentDidMount() {
        axios.get(this.urls.unbilled_vendors)
            .then(response => {
                let selected_vendor_option = response.data[0] ? response.data[0].id : ''
                this.setState({ vendor_options: response.data, selected_vendor_option: selected_vendor_option })
                this.loadUnbilledDeliveryOrders(selected_vendor_option)
            })
            .catch(error => {
                console.log(error)
            })
    }

    onFormSubmit(e) {
        e.preventDefault()

        axios.post(this.urls.invoice_creation, this.getFormData())
            .then(response => {
                window.location.replace(response.data.redirect)
            })
            .catch(error => {
                this.setState({ error_data: error.response.data })
            })
    }
    
    render() {
        return (
            <form onSubmit={this.onFormSubmit}>
                <div className="form-group">
                    <label htmlFor="received_at"> Receivement Date: </label>
                    <InputFormControl
                        value={this.state.received_at}
                        onChange={(e) => { this.setState({ received_at: e.target.value }) }}
                        type='date'
                        isInvalid={get(this.state.error_data, 'errors.received_at[0]', false)}
                        invalidFeedback={get(this.state.error_data, 'errors.received_at[0]', '')}
                        />
                </div>

                <div className="form-group">
                    <label htmlFor="number"> Number: </label>
                    <InputFormControl
                        value={this.state.number}
                        onChange={(e) => { this.setState({ number: e.target.value }) }}
                        type='text'
                        isInvalid={get(this.state.error_data, 'errors.number[0]', false)}
                        invalidFeedback={get(this.state.error_data, 'errors.number[0]', '')}
                        />
                </div>

                <div className="form-group">
                    <label htmlFor="vendor_id"> Vendor: </label>
                    <select value={this.state.selected_vendor_option} onChange={this.onVendorSelectionChange} className="form-control">
                        {this.state.vendor_options.map(vendor =>
                            <option value={vendor.id} key={vendor.id}> {vendor.name} </option>
                        )}
                    </select>
                    <small className="form-text text-muted">
                        Note: Only vendors with unbilled delivery orders are shown
                    </small>
                </div>

                <div className="form-group">
                    <label> Delivery Orders: </label>
                    
                    {get(this.state.error_data, 'errors.delivery_orders[0]', '') &&
                        <p className="text-danger">
                            You need to select at least one delivery order.
                        </p>
                    }

                    <div className="list-group" style={{height: '30rem', overflow: 'scroll'}}>
                        {this.state.delivery_order_options.map(delivery_order => 
                            <div
                                key={delivery_order.id}
                                onClick={() => { this.onSelectDeliveryOrder(delivery_order.id) }} key={delivery_order.id}
                                className={classNames(['list-group-item', {'list-group-item-info': delivery_order.is_selected}])}>

                                <h5>
                                    To <strong> {delivery_order.target.name} </strong> on <strong> {delivery_order.received_at} </strong>
                                </h5>

                                <ol>
                                   {delivery_order.delivery_order_items.map(do_item => 
                                        <li key={do_item.item_id}>
                                            {do_item.item.name} <i className="fa fa-times"></i> {do_item.quantity} {do_item.item.unit}
                                        </li>
                                    )} 
                                </ol>
                            </div>
                        )}
                    </div>
                </div>

                <div className="text-right">
                    <button className="btn btn-primary btn-sm">
                        Create
                        <i className="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        )
    }
}

const rootElem = document.querySelector('#create-invoice-form')
if (rootElem) {
    ReactDOM.render(<CreateInvoiceForm/>, rootElem)
}