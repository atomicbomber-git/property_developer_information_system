import React, {Component, Fragment} from 'react';
import classNames from 'classnames';

function SelectFormControl({value, options, isInvalid, invalidFeedback, className, ...props}) {
    const class_names = classNames({
        'custom-select': true,
        ...className,
        'is-invalid': isInvalid
    })

    const defaultInvalidFeedback = (isInvalid && 
        <div className="invalid-feedback">
            <p> {invalidFeedback} </p>
        </div>
    )
    
    return (
        <Fragment>
            <select value={value} className={class_names} {...props}>
                {options.map(option => {
                    return <option value={option.value} key={option.key}> {option.name} </option>
                })}
            </select>
            {defaultInvalidFeedback}
        </Fragment>
    )
}

export default SelectFormControl