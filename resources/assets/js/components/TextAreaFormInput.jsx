import React, {Component, Fragment} from 'react';
import classNames from 'classnames';

function TextAreaFormInput({ isInvalid, invalidFeedback, dataType, ...props }) {

    let class_names = classNames({
        'form-control': true,
        ...props.className,
        'is-invalid': isInvalid
    });
    
    return (
        <Fragment>
            <textarea {...props} type={dataType} className={class_names}></textarea>
            { isInvalid && <div className="invalid-feedback">
                <p>
                    { invalidFeedback }
                </p>
            </div> }
        </Fragment>
    )
}

export default InputFormControl;