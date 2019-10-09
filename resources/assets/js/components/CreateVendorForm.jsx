import React, {Component, Fragment} from 'react'
import ReactDOM from 'react-dom'
import InputFormControl from './InputFormControl'
import {get, pick, keyBy, map} from 'lodash'

class CreateVendorForm extends React.Component {
    constructor(props) {
        super(props)

        this.keyCounter = 0

        this.state = {
            name: '',
            address: '',
            code: '',
            contact_persons: [],
            errorData: {}
        }

        this.mapStateToFormData = this.mapStateToFormData.bind(this)
        this.onClickAddContactPersonButton = this.onClickAddContactPersonButton.bind(this)
        this.onClickRemoveContactPersonButton = this.onClickRemoveContactPersonButton.bind(this)
        this.onFormSubmit = this.onFormSubmit.bind(this)
    }

    mapStateToFormData()
    {
        return {
            name: this.state.name,
            address: this.state.address,
            code: this.state.code,
            contact_people: keyBy(this.state.contact_persons, 'key')
        }
    }

    onFormSubmit(e)
    {
        e.preventDefault()
        axios.post(`/vendor/create`, this.mapStateToFormData())
            .then(response => {
                this.setState({ errorData: { } })
                window.location.replace(response.data.redirect)
            })
            .catch(error => {
                if (error.response.data) {
                    this.setState({ errorData: error.response.data })
                }
            })
    }

    onClickAddContactPersonButton()
    {
        this.setState(prevState => {
            return { contact_persons: [...prevState.contact_persons, { key: this.keyCounter++, name: '', phone: ''}] }
        })
    }

    onClickRemoveContactPersonButton(key)
    {
        this.setState(prevState => {
            return { contact_persons: prevState.contact_persons.filter(cp => cp.key != key) }
        })
    }

    render() {
        return (
            <form onSubmit={this.onFormSubmit}>
                <div className="form-group">
                    <label htmlFor="name"> Vendor Name: </label>
                    <InputFormControl
                        id="name"
                        isInvalid={get(this.state.errorData, 'errors.name[0]', false)}
                        invalidFeedback={get(this.state.errorData, 'errors.name[0]', '')}
                        value={this.state.name}
                        onChange={(e) => { this.setState({ name: e.target.value }) }}
                        placeholder="Name of the vendor"
                        />
                </div>

                <div className="form-group">
                    <label htmlFor="name"> Vendor Code: </label>
                    <InputFormControl
                        id="name"
                        isInvalid={get(this.state.errorData, 'errors.code[0]', false)}
                        invalidFeedback={get(this.state.errorData, 'errors.code[0]', '')}
                        value={this.state.code}
                        onChange={(e) => { this.setState({ code: e.target.value }) }}
                        placeholder="Code of the vendor"
                        />
                </div>

                <div className="form-group">
                    <label htmlFor="address"> Vendor Address: </label>
                    <InputFormControl
                        id="address"
                        isInvalid={get(this.state.errorData, 'errors.address[0]', false)}
                        invalidFeedback={get(this.state.errorData, 'errors.address[0]', '')}
                        value={this.state.address}
                        onChange={(e) => { this.setState({ address: e.target.value }) }}
                        placeholder="Address of the vendor"
                        />
                </div>

                <div className="form-group">
                    <label htmlFor="contact_persons"> Contact Persons: </label>

                    {this.state.contact_persons.map(contact_person => {
                        return (
                            <div key={contact_person.key}>
                                <div className="input-group mt-2">
                                    <InputFormControl
                                        isInvalid={get(this.state.errorData, ['errors', `contact_people.${contact_person.key}.name`, 0], false)}
                                        value={this.state.contact_persons.find(cp => cp.key == contact_person.key).name}
                                        onChange={(e) => {
                                            let name = e.target.value;
                                            this.setState(prevState => {
                                                return { contact_persons: prevState.contact_persons.map(cp => {
                                                    if (cp.key == contact_person.key) {
                                                        return {...cp, name: name }
                                                    }
                                                    return cp
                                                })}
                                            })
                                        }}
                                        placeholder="Name"/>
                                    <InputFormControl
                                        isInvalid={get(this.state.errorData, ['errors', `contact_people.${contact_person.key}.phone`, 0], false)}
                                        value={this.state.contact_persons.find(cp => cp.key == contact_person.key).phone}
                                        onChange={(e) => {
                                            let phone = e.target.value;
                                            this.setState(prevState => {
                                                return { contact_persons: prevState.contact_persons.map(cp => {
                                                    if (cp.key == contact_person.key) {
                                                        return {...cp, phone: phone }
                                                    }
                                                    return cp
                                                })}
                                            })
                                        }}
                                        placeholder="Phone"/>

                                    <div className="input-group-append">
                                        <button onClick={() => { this.onClickRemoveContactPersonButton(contact_person.key) }} type="button" className="btn btn-outline-danger btn-sm">
                                            <i className="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <div className='text-danger'>
                                        {get(this.state.errorData, ['errors', `contact_people.${contact_person.key}.name`, 0], false) || ''}
                                    </div>
                                    <div className='text-danger'>
                                        {get(this.state.errorData, ['errors', `contact_people.${contact_person.key}.phone`, 0], false) || ''}
                                    </div>
                                </div>
                            </div>
                        )
                    })}

                    <div className="text-right mt-2">
                        <button onClick={this.onClickAddContactPersonButton} type="button" className="btn btn-sm btn-default">
                            <i className="fa fa-plus"></i>
                        </button>
                    </div>

                    <div className="text-right mt-3">
                        <button className="btn btn-primary btn-sm">
                            Create Vendor
                            <i className="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
        )
    }
}

const rootElem = document.getElementById('create-vendor-form')
if (rootElem) {
    ReactDOM.render(<CreateVendorForm/>, rootElem)
}
