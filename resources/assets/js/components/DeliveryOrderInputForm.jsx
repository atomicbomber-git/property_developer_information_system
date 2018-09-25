import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {get, keyBy, includes, groupBy} from 'lodash';
import classNames from 'classnames';
import SelectFormControl from './SelectFormControl';
import InputFormControl from './InputFormControl';

export default class DeliveryOrderInputForm extends Component {
    constructor(props) {
        super(props);

        this.keyCounter = 0;

        this.state = {
            firstTimeLoadFinished: false,
            users: [],
            vendors: [],
            storages: [],
            selected_vendor: "",
            vendor_items: [],
            picked_vendor_items: [],
            selected_vendor_item: "",
            selected_receiver: "",
            selected_date: "",
            selected_storage: "",
            errorData: null
        };

        this.handleVendorSelectionChange = this.handleVendorSelectionChange.bind(this);
        this.handleVendorItemSelectionChange = this.handleVendorItemSelectionChange.bind(this);
        this.handleAddItem = this.handleAddItem.bind(this);
        this.handleItemQuantityChange = this.handleItemQuantityChange.bind(this);
        this.handleUnpickItem = this.handleUnpickItem.bind(this);
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
        this.getFormData = this.getFormData.bind(this);
    }

    componentDidMount() {

        axios.get(`/user/index`)
            .then(response => {
                    this.setState({
                        users: response.data,
                        selected_receiver: get(response.data, '[0].id', '')
                    }); 
                });
        
        axios.get(`/storage/index`)
            .then(response => {
                this.setState({
                    storages: response.data,
                    selected_storage: get(response.data, '[0].id', '')
                }); 
            });

        axios.get(`/vendor/index`)
            .then(response => {

                this.setState({vendors: response.data, selected_vendor: response.data[0].id });

                if (response.data.length == 0)
                    return;

                axios.get(`/vendor/item/${response.data[0].id}`)
                    .then(response => {

                        response.data = response.data
                            .sort((a, b) => { return a.name.localeCompare(b); })

                        let items = response.data
                        this.setState({
                            vendor_items: items,
                            selected_vendor_item: response.data[0].id,
                            firstTimeLoadFinished: true
                        });
                    });

            })
    }

    getFormData() {
        let grouped = groupBy(this.state.picked_vendor_items, 'id')
        let delivery_items = Object.keys(grouped)
            .map(key => {
                let temp = {}
                temp.id = key
                temp.quantity = grouped[key]
                    .map(item => item.quantity)
                    .reduce((acc, val) => {
                        return acc + parseFloat(val)
                    }, 0)
                return temp
            })

        return {
            received_at: this.state.selected_date,
            receiver_id: this.state.selected_receiver,
            source_id: this.state.selected_vendor,
            target_id: this.state.selected_storage,
            delivery_items: keyBy(delivery_items, 'id')
        }
    }

    handleFormSubmit(e) {
        e.preventDefault()

        axios.post(`/delivery_order/create`, this.getFormData())
            .then(response => { window.location.replace(response.data.redirect) })
            .catch(error => {
                if (error.response.data) {
                    this.setState({ errorData: error.response.data })
                    return
                }

                alert('Form submit failed.')
            })

    }

    handleVendorSelectionChange(e) {
        this.setState({ selected_vendor: e.target.value });

        axios.get(`/vendor/item/${e.target.value}`)
            .then(response => {
                let selected_vendor_item = response.data[0] ? response.data[0].id : ''
                this.setState({ vendor_items: response.data, selected_vendor_item: selected_vendor_item })
            });
    }

    handleVendorItemSelectionChange(e) {
        this.setState({ selected_vendor_item: e.target.value });
    }

    handleAddItem() {
        let selected_item = this.state.vendor_items.find(item => item.id == this.state.selected_vendor_item)
        let picked_vendor_item = {key: this.keyCounter++, ...selected_item, quantity: 1 }
        let picked_vendor_items = [...this.state.picked_vendor_items, picked_vendor_item]

        this.setState({
            picked_vendor_items: picked_vendor_items
        });
    }

    handleItemQuantityChange(key, value) {
        this.setState({
            picked_vendor_items: this.state.picked_vendor_items.map(item => {
                if (key == item.key) {
                    return {...item, quantity: value}
                }
                return item;
            })
        });
    }

    handleUnpickItem(item_id) {
        let items = this.state.picked_vendor_items.filter(item => item.key != item_id);
        this.setState({ picked_vendor_items: items });
    }

    renderItemSelections() {
        if (this.state.firstTimeLoadFinished && this.state.vendor_items.length == 0) {
            return (
                <div className="alert alert-warning">
                    <i className="fa fa-warning mr-2"></i>
                    There are no vendor items at all.
                </div>
            );
        }

        const delivery_item_error = get(this.state.errorData, 'errors.delivery_items[0]', false);
        
        return (
            <Fragment>
                <div className="input-group">
                    <select onChange={this.handleVendorItemSelectionChange} value={this.state.selected_vendor_item} className="custom-select">
                        {
                            this.state.vendor_items
                                .map(item => (<option value={item.id} key={item.id}> {item.name} ({item.unit}) </option>))
                        }
                    </select>
                    
                    <div className="input-group-append">
                        <button type="button" onClick={this.handleAddItem} className="btn btn-secondary">
                            <i className="fa fa-plus"></i>
                        </button>
                    </div>
                </div>

                {delivery_item_error &&
                    <div className="mt-2 alert alert-danger">
                        {delivery_item_error}
                    </div>
                }
                
            </Fragment>
        );
    }

    renderSelectedItems() {
        return (
            this.state.picked_vendor_items
                .map(item => {  
                    let quantityError = get(this.state.errorData, ['errors', `delivery_items.${item.id}.quantity`, '0'], false);

                    return (
                        <Fragment key={item.key}>
                            <div className="input-group input-group-sm mt-2">
                                <div className="input-group-prepend">
                                    <span style={{ width: '24rem' }} className="input-group-text">
                                        {item.name} ({item.unit})
                                    </span>
                                </div>

                                <input
                                    className={classNames('form-control', {'is-invalid': quantityError} )}
                                    onChange={(e) => { this.handleItemQuantityChange(item.key, e.target.value) }}
                                    type="number" step="0.001" value={item.quantity} />

                                <div className="input-group-append">
                                    <button type="button" onClick={() => { this.handleUnpickItem(item.key) }} className="btn btn-sm btn-outline-danger">
                                        <i className="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            {quantityError && 
                                <p className="text-danger">
                                    {quantityError}
                                </p>
                            }

                        </Fragment>
                    )
                })
        );
    }

    render() {
        return (
            <form onSubmit={this.handleFormSubmit}>
                <div className="form-group">
                    <label> Receiver: </label>
                    <SelectFormControl
                        value={this.state.selected_receiver}
                        isInvalid={ get(this.state.errorData, 'errors.receiver_id[0]', false) }
                        invalidFeedback={ get(this.state.errorData, 'errors.receiver_id[0]', '') }
                        options={this.state.users.map(user => { return {value: user.id, key: user.id, name: user.name}})}
                        onChange={(e) => { this.setState({ selected_receiver: e.target.value }) }}
                        />
                </div>

                <div className="form-group">
                    <label htmlFor=""> Storage: </label>
                    <SelectFormControl
                        value={this.state.selected_storage}
                        isInvalid={ get(this.state.errorData, 'errors.target_id[0]', false) }
                        invalidFeedback={ get(this.state.errorData, 'errors.target_id[0]', '') }
                        options={this.state.storages.map(storage => { return {value: storage.id, key: storage.id, name: storage.name}})}
                        onChange={(e) => { this.setState({ selected_storage: e.target.value }) }}
                        />
                </div>

                <div className="form-group">
                    <label> Receivement Date: </label>
                    <InputFormControl
                        type={"date"}
                        isInvalid={ get(this.state.errorData, 'errors.received_at[0]', false) }
                        invalidFeedback={ get(this.state.errorData, 'errors.received_at[0]', '') }
                        value={this.state.selected_date}
                        onChange={(e) => { this.setState({selected_date: e.target.value}) }}
                    />
                </div>
                
                <div className="form-group">
                    <label htmlFor=""> Vendor: </label>
                    <SelectFormControl
                        value={this.state.selected_vendor}
                        disabled={this.state.picked_vendor_items.length != 0}
                        isInvalid={ get(this.state.errorData, 'errors.target_id[0]', false) }
                        invalidFeedback={ get(this.state.errorData, 'errors.target_id[0]', '') }
                        options={this.state.vendors.map(item => { return {value: item.id, key: item.id, name: item.name}})}
                        onChange={this.handleVendorSelectionChange}
                        />
                </div>

                <div className="form-group">
                    <label> Vendor Items: </label>
                    {this.renderItemSelections()}
                </div>

                <div className="form-group">
                    <label> Selected Items: </label>
                    {this.renderSelectedItems()}
                </div>
                
                <div className="text-right mt-4">
                    <button className="btn btn-primary btn-sm">
                        Create Delivery Order
                        <i className="fa fa-plus"></i>
                    </button>
                </div>

            </form>
        );
    }
}

if (document.getElementById('delivery-order-input-form')) {
    ReactDOM.render(<DeliveryOrderInputForm />, document.getElementById('delivery-order-input-form'));
}