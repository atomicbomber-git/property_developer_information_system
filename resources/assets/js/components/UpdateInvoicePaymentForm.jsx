import React, {Component, Fragment} from 'react'
import ReactDOM from 'react-dom'
import InputFormControl from './InputFormControl'
import {debounce, get} from 'lodash';
import axios from 'axios';

class UpdateInvoicePaymentForm extends Component {
    constructor(props) {
        super(props)

        this.payment_methods = [
            { name: 'cash', label: 'Cash' },
            { name: 'new_giro', label: 'New Giro' },
            { name: 'giro', label: 'Old Giro' }    
        ];

        this.state = {
            selected_payment_method: 'new_giro',
            giro_options: [],
            cash_amount: '',
            giro_number: '',
            selected_giro_option: '',
            errorData: {}
        }

        this.onPaymentMethodChange = this.onPaymentMethodChange.bind(this)
        this.onGiroFilterChange = this.onGiroFilterChange.bind(this)
        this.onGiroSelectChange = this.onGiroSelectChange.bind(this)
        this.debouncedLoadGiroOptions = debounce(this.loadGiroOptions.bind(this), 400)
        this.onFormSubmit = this.onFormSubmit.bind(this)
        this.getFormData = this.getFormData.bind(this)
    }

    getFormData() {
        return {
            payment_method: this.state.selected_payment_method,
            cash_amount: this.state.cash_amount,
            giro_number: this.state.giro_number,
            giro_id: this.state.selected_giro_option
        }
    }

    componentDidMount() {
        this.loadGiroOptions('')
    }

    onPaymentMethodChange(e) {
        this.setState({ selected_payment_method: e.target.value })
    }

    onGiroFilterChange(e) {
        this.debouncedLoadGiroOptions(e.target.value)
    }

    onGiroSelectChange(e) {
        this.setState({ selected_giro_option: e.target.value })
    }

    loadGiroOptions(filter) {
        axios.get(`/giro/search?number=${filter}`)
            .then(response => {
                let new_selected_giro_option = response.data[0] ? response.data[0].id : ''

                this.setState({
                    giro_options: response.data,
                    selected_giro_option: new_selected_giro_option
                })
            })
            .catch(error => {
                
            })
    }

    onFormSubmit(e) {
        e.preventDefault()
        axios.post(`/invoice/pay/${this.props.invoiceId}`, this.getFormData())
            .then(response => {
                window.location.replace(response.data.redirect)
            })
            .catch(error => {
                this.setState({
                    errorData: error.response.data
                })
            })
    }

    render() {
        return (
            <form onSubmit={this.onFormSubmit}>
                <div className="form-group">
                    <label htmlFor="payment_method"> Payment Method: </label>
                    <select className="form-control form-control-sm" value={this.state.selected_payment_method} onChange={this.onPaymentMethodChange} name="payment_method" id="payment_method">
                        {this.payment_methods.map(method =>
                            <option key={method.name} value={method.name}> {method.label} </option>)
                        }
                    </select>
                </div>

                {this.state.selected_payment_method == 'cash' &&
                    <div className="form-group">
                        <label htmlFor="cash_amount"> Cash Amount: </label>
                        <InputFormControl
                            isInvalid={get(this.state.errorData, 'errors.cash_amount[0]', false)}
                            invalidFeedback={get(this.state.errorData, 'errors.cash_amount[0]', '')}
                            type="number"
                            value={this.state.cash_amount}
                            onChange={(e) => { this.setState({ cash_amount: e.target.value })}}
                            className={{'form-control-sm' : true}} placeholder="Cash amount"/>
                    </div>
                }

                {this.state.selected_payment_method == 'new_giro' &&
                    <div className="form-group">
                        <label htmlFor="giro_number"> Giro Number: </label>
                        <InputFormControl
                            isInvalid={get(this.state.errorData, 'errors.giro_number[0]', false)}
                            invalidFeedback={get(this.state.errorData, 'errors.giro_number[0]', '')}
                            value={this.state.giro_number}
                            onChange={(e) => { this.setState({ giro_number: e.target.value }) }}
                            className={{'form-control-sm' : true}} placeholder="Giro number"/>
                    </div>
                }

                {this.state.selected_payment_method == 'giro' &&
                    <Fragment>
                        <div className="alert alert-info">
                            <div className="form-group">
                                <label htmlFor="giro_number_filter"> Filter Selection By Giro Number: </label>
                                <InputFormControl onChange={this.onGiroFilterChange} className={{'form-control-sm' : true}} placeholder="Giro number"/>
                            </div>
                        </div>

                        <div className="form-group">
                            <label htmlFor="giro_id"> Giro Number: </label>
                            <select value={this.state.selected_giro_option} onChange={this.onGiroSelectChange} className="form-control form-control-sm" name="giro_id" id="giro_id">
                                {this.state.giro_options.map(giro => 
                                    <option key={giro.id} value={giro.id}> {giro.number} </option>
                                )}
                            </select>
                        </div>
                    </Fragment>
                }

                <div className="text-right">
                    <button className="btn btn-primary btn-sm">
                        Update Payment
                        <i className="fa fa-usd"></i>
                    </button>
                </div>
            </form>
        );
    }
}

const rootElem = document.getElementById('update-invoice-payment-form')
if (rootElem) {
    let invoiceId = document.getElementById('invoice-id').dataset.invoiceId;
    ReactDOM.render(<UpdateInvoicePaymentForm invoiceId={invoiceId}/>, rootElem)
}