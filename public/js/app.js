(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./resources/assets/js/app.js":
/*!************************************!*\
  !*** ./resources/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */
__webpack_require__(/*! ./bootstrap */ "./resources/assets/js/bootstrap.js");
/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


__webpack_require__(/*! ./components/DeliveryOrderInputForm.jsx */ "./resources/assets/js/components/DeliveryOrderInputForm.jsx");

__webpack_require__(/*! ./components/CreateVendorForm.jsx */ "./resources/assets/js/components/CreateVendorForm.jsx");

__webpack_require__(/*! ./components/AddContactPersonsForm.jsx */ "./resources/assets/js/components/AddContactPersonsForm.jsx");

__webpack_require__(/*! ./components/UpdateDeliveryOrderPricesForm */ "./resources/assets/js/components/UpdateDeliveryOrderPricesForm.jsx");

__webpack_require__(/*! ./components/UpdateInvoicePaymentForm */ "./resources/assets/js/components/UpdateInvoicePaymentForm.jsx");

__webpack_require__(/*! ./components/CreateInvoiceForm */ "./resources/assets/js/components/CreateInvoiceForm.jsx");

window.Vue = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
var app = new Vue({
  el: '#app'
});

/***/ }),

/***/ "./resources/assets/js/bootstrap.js":
/*!******************************************!*\
  !*** ./resources/assets/js/bootstrap.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
window.Popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"];
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from 'laravel-echo'
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

/***/ }),

/***/ "./resources/assets/js/components/AddContactPersonsForm.jsx":
/*!******************************************************************!*\
  !*** ./resources/assets/js/components/AddContactPersonsForm.jsx ***!
  \******************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }







var AddContactPersonsForm =
/*#__PURE__*/
function (_React$Component) {
  _inherits(AddContactPersonsForm, _React$Component);

  function AddContactPersonsForm(props) {
    var _this;

    _classCallCheck(this, AddContactPersonsForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(AddContactPersonsForm).call(this, props));
    _this.keyCounter = 0;
    _this.state = {
      contact_persons: [],
      errorData: []
    };
    _this.mapStateToFormData = _this.mapStateToFormData.bind(_assertThisInitialized(_this));
    _this.onClickAddContactPersonButton = _this.onClickAddContactPersonButton.bind(_assertThisInitialized(_this));
    _this.onClickRemoveContactPersonButton = _this.onClickRemoveContactPersonButton.bind(_assertThisInitialized(_this));
    _this.onFormSubmit = _this.onFormSubmit.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(AddContactPersonsForm, [{
    key: "mapStateToFormData",
    value: function mapStateToFormData() {
      return {
        contact_people: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["keyBy"])(this.state.contact_persons, 'key')
      };
    }
  }, {
    key: "onFormSubmit",
    value: function onFormSubmit(e) {
      var _this2 = this;

      e.preventDefault();
      axios__WEBPACK_IMPORTED_MODULE_4___default.a.post("/vendor/contact_persons/".concat(this.props.vendorId, "/create"), this.mapStateToFormData()).then(function (response) {
        _this2.setState({
          errorData: {}
        });

        window.location.replace(response.data.redirect);
      })["catch"](function (error) {
        if (error.response.data) {
          _this2.setState({
            errorData: error.response.data
          });
        }
      });
    }
  }, {
    key: "onClickAddContactPersonButton",
    value: function onClickAddContactPersonButton() {
      var _this3 = this;

      this.setState(function (prevState) {
        return {
          contact_persons: [].concat(_toConsumableArray(prevState.contact_persons), [{
            key: _this3.keyCounter++,
            name: '',
            phone: ''
          }])
        };
      });
    }
  }, {
    key: "onClickRemoveContactPersonButton",
    value: function onClickRemoveContactPersonButton(key) {
      this.setState(function (prevState) {
        return {
          contact_persons: prevState.contact_persons.filter(function (cp) {
            return cp.key != key;
          })
        };
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this4 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.onFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.contact_people[0]', false) && this.state.contact_persons.length == 0 && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-danger"
      }, "At least one contact person must be added before submitting"), this.state.contact_persons.map(function (contact_person) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          key: contact_person.key
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group mt-2"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
          isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".name"), 0], false),
          value: _this4.state.contact_persons.find(function (cp) {
            return cp.key == contact_person.key;
          }).name,
          onChange: function onChange(e) {
            var name = e.target.value;

            _this4.setState(function (prevState) {
              return {
                contact_persons: prevState.contact_persons.map(function (cp) {
                  if (cp.key == contact_person.key) {
                    return _objectSpread({}, cp, {
                      name: name
                    });
                  }

                  return cp;
                })
              };
            });
          },
          placeholder: "Name"
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
          isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".phone"), 0], false),
          value: _this4.state.contact_persons.find(function (cp) {
            return cp.key == contact_person.key;
          }).phone,
          onChange: function onChange(e) {
            var phone = e.target.value;

            _this4.setState(function (prevState) {
              return {
                contact_persons: prevState.contact_persons.map(function (cp) {
                  if (cp.key == contact_person.key) {
                    return _objectSpread({}, cp, {
                      phone: phone
                    });
                  }

                  return cp;
                })
              };
            });
          },
          placeholder: "Phone"
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group-append"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
          onClick: function onClick() {
            _this4.onClickRemoveContactPersonButton(contact_person.key);
          },
          type: "button",
          className: "btn btn-outline-danger btn-sm"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
          className: "fa fa-times"
        })))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "text-danger"
        }, Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".name"), 0], false) || ''), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "text-danger"
        }, Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".phone"), 0], false) || '')));
      }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right mt-2"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        onClick: this.onClickAddContactPersonButton,
        type: "button",
        className: "btn btn-sm btn-default"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      })))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        type: "submit",
        className: "btn btn-primary btn-sm"
      }, "Add Contact Persons", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      }))));
    }
  }]);

  return AddContactPersonsForm;
}(react__WEBPACK_IMPORTED_MODULE_0___default.a.Component);

var rootElem = document.getElementById('add-contact-persons-form');
var dataContainer = document.getElementById('vendor-id');

if (rootElem) {
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(AddContactPersonsForm, {
    vendorId: dataContainer.dataset.vendorId
  }), rootElem);
}

/***/ }),

/***/ "./resources/assets/js/components/CreateInvoiceForm.jsx":
/*!**************************************************************!*\
  !*** ./resources/assets/js/components/CreateInvoiceForm.jsx ***!
  \**************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_4__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }







var CreateInvoiceForm =
/*#__PURE__*/
function (_Component) {
  _inherits(CreateInvoiceForm, _Component);

  function CreateInvoiceForm(props) {
    var _this;

    _classCallCheck(this, CreateInvoiceForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(CreateInvoiceForm).call(this, props));
    _this.urls = {
      unbilled_vendors: "/vendor/api/unbilled",
      unbilled_delivery_orders: function unbilled_delivery_orders(vendor_id) {
        return "/vendor/api/unbilled_delivery_orders/".concat(vendor_id);
      },
      invoice_creation: "/invoice/create"
    };
    _this.state = {
      received_at: '',
      number: '',
      vendor_options: [],
      selected_vendor_option: '',
      delivery_order_options: [],
      error_data: {}
    };
    _this.onVendorSelectionChange = _this.onVendorSelectionChange.bind(_assertThisInitialized(_this));
    _this.loadUnbilledDeliveryOrders = _this.loadUnbilledDeliveryOrders.bind(_assertThisInitialized(_this));
    _this.onSelectDeliveryOrder = _this.onSelectDeliveryOrder.bind(_assertThisInitialized(_this));
    _this.onFormSubmit = _this.onFormSubmit.bind(_assertThisInitialized(_this));
    _this.getFormData = _this.getFormData.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(CreateInvoiceForm, [{
    key: "getFormData",
    value: function getFormData() {
      return {
        received_at: this.state.received_at,
        number: this.state.number,
        vendor_id: this.state.selected_vendor_option,
        delivery_orders: this.state.delivery_order_options.filter(function (delivery_order) {
          return delivery_order.is_selected;
        }).map(function (delivery_order) {
          return delivery_order.id;
        })
      };
    }
  }, {
    key: "loadUnbilledDeliveryOrders",
    value: function loadUnbilledDeliveryOrders(vendorId) {
      var _this2 = this;

      axios.get(this.urls.unbilled_delivery_orders(vendorId)).then(function (response) {
        var delivery_orders = response.data.map(function (delivery_order) {
          return _objectSpread({}, delivery_order, {
            is_selected: false
          });
        });

        _this2.setState({
          delivery_order_options: delivery_orders
        });
      })["catch"](function (error) {
        console.log(error);
      });
    }
  }, {
    key: "onVendorSelectionChange",
    value: function onVendorSelectionChange(e) {
      var _this3 = this;

      this.setState({
        selected_vendor_option: e.target.value
      });
      axios.get(this.urls.unbilled_delivery_orders(e.target.value)).then(function (response) {
        var delivery_orders = response.data.map(function (delivery_order) {
          return _objectSpread({}, delivery_order, {
            is_selected: false
          });
        });

        _this3.setState({
          delivery_order_options: delivery_orders
        });
      })["catch"](function (error) {
        console.log(error);
      });
    }
  }, {
    key: "onSelectDeliveryOrder",
    value: function onSelectDeliveryOrder(delivery_order_id) {
      var updated = this.state.delivery_order_options.map(function (delivery_order) {
        if (delivery_order.id == delivery_order_id) {
          return _objectSpread({}, delivery_order, {
            is_selected: !delivery_order.is_selected
          });
        }

        return delivery_order;
      });
      this.setState({
        delivery_order_options: updated
      });
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this4 = this;

      axios.get(this.urls.unbilled_vendors).then(function (response) {
        var selected_vendor_option = response.data[0] ? response.data[0].id : '';

        _this4.setState({
          vendor_options: response.data,
          selected_vendor_option: selected_vendor_option
        });

        _this4.loadUnbilledDeliveryOrders(selected_vendor_option);
      })["catch"](function (error) {
        console.log(error);
      });
    }
  }, {
    key: "onFormSubmit",
    value: function onFormSubmit(e) {
      var _this5 = this;

      e.preventDefault();
      axios.post(this.urls.invoice_creation, this.getFormData()).then(function (response) {
        window.location.replace(response.data.redirect);
      })["catch"](function (error) {
        _this5.setState({
          error_data: error.response.data
        });
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this6 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.onFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "received_at"
      }, " Receivement Date: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        value: this.state.received_at,
        onChange: function onChange(e) {
          _this6.setState({
            received_at: e.target.value
          });
        },
        type: "date",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_4__["get"])(this.state.error_data, 'errors.received_at[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_4__["get"])(this.state.error_data, 'errors.received_at[0]', '')
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "number"
      }, " Number: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        value: this.state.number,
        onChange: function onChange(e) {
          _this6.setState({
            number: e.target.value
          });
        },
        type: "text",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_4__["get"])(this.state.error_data, 'errors.number[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_4__["get"])(this.state.error_data, 'errors.number[0]', '')
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "vendor_id"
      }, " Vendor: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
        value: this.state.selected_vendor_option,
        onChange: this.onVendorSelectionChange,
        className: "form-control"
      }, this.state.vendor_options.map(function (vendor) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
          value: vendor.id,
          key: vendor.id
        }, " ", vendor.name, " ");
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("small", {
        className: "form-text text-muted"
      }, "Note: Only vendors with unbilled delivery orders are shown")), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, " Delivery Orders: "), Object(lodash__WEBPACK_IMPORTED_MODULE_4__["get"])(this.state.error_data, 'errors.delivery_orders[0]', '') && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
        className: "text-danger"
      }, "You need to select at least one delivery order."), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "list-group",
        style: {
          height: '30rem',
          overflow: 'scroll'
        }
      }, this.state.delivery_order_options.map(function (delivery_order) {
        var _React$createElement;

        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", (_React$createElement = {
          key: delivery_order.id,
          onClick: function onClick() {
            _this6.onSelectDeliveryOrder(delivery_order.id);
          }
        }, _defineProperty(_React$createElement, "key", delivery_order.id), _defineProperty(_React$createElement, "className", classnames__WEBPACK_IMPORTED_MODULE_3___default()(['list-group-item', {
          'list-group-item-info': delivery_order.is_selected
        }])), _React$createElement), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h5", null, "To ", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("strong", null, " ", delivery_order.target.name, " "), " on ", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("strong", null, " ", delivery_order.received_at, " ")), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("ol", null, delivery_order.delivery_order_items.map(function (do_item) {
          return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("li", {
            key: do_item.item_id
          }, do_item.item.name, " ", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
            className: "fa fa-times"
          }), " ", do_item.quantity, " ", do_item.item.unit);
        })));
      }))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        className: "btn btn-primary btn-sm"
      }, "Create", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      }))));
    }
  }]);

  return CreateInvoiceForm;
}(react__WEBPACK_IMPORTED_MODULE_0__["Component"]);

var rootElem = document.querySelector('#create-invoice-form');

if (rootElem) {
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(CreateInvoiceForm, null), rootElem);
}

/***/ }),

/***/ "./resources/assets/js/components/CreateVendorForm.jsx":
/*!*************************************************************!*\
  !*** ./resources/assets/js/components/CreateVendorForm.jsx ***!
  \*************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }






var CreateVendorForm =
/*#__PURE__*/
function (_React$Component) {
  _inherits(CreateVendorForm, _React$Component);

  function CreateVendorForm(props) {
    var _this;

    _classCallCheck(this, CreateVendorForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(CreateVendorForm).call(this, props));
    _this.keyCounter = 0;
    _this.state = {
      name: '',
      address: '',
      code: '',
      contact_persons: [],
      errorData: {}
    };
    _this.mapStateToFormData = _this.mapStateToFormData.bind(_assertThisInitialized(_this));
    _this.onClickAddContactPersonButton = _this.onClickAddContactPersonButton.bind(_assertThisInitialized(_this));
    _this.onClickRemoveContactPersonButton = _this.onClickRemoveContactPersonButton.bind(_assertThisInitialized(_this));
    _this.onFormSubmit = _this.onFormSubmit.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(CreateVendorForm, [{
    key: "mapStateToFormData",
    value: function mapStateToFormData() {
      return {
        name: this.state.name,
        address: this.state.address,
        code: this.state.code,
        contact_people: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["keyBy"])(this.state.contact_persons, 'key')
      };
    }
  }, {
    key: "onFormSubmit",
    value: function onFormSubmit(e) {
      var _this2 = this;

      e.preventDefault();
      console.log(this.mapStateToFormData());
      axios.post("/vendor/create", this.mapStateToFormData()).then(function (response) {
        _this2.setState({
          errorData: {}
        });

        window.location.replace(response.data.redirect);
      })["catch"](function (error) {
        if (error.response.data) {
          _this2.setState({
            errorData: error.response.data
          });
        }
      });
    }
  }, {
    key: "onClickAddContactPersonButton",
    value: function onClickAddContactPersonButton() {
      var _this3 = this;

      this.setState(function (prevState) {
        return {
          contact_persons: [].concat(_toConsumableArray(prevState.contact_persons), [{
            key: _this3.keyCounter++,
            name: '',
            phone: ''
          }])
        };
      });
    }
  }, {
    key: "onClickRemoveContactPersonButton",
    value: function onClickRemoveContactPersonButton(key) {
      this.setState(function (prevState) {
        return {
          contact_persons: prevState.contact_persons.filter(function (cp) {
            return cp.key != key;
          })
        };
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this4 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.onFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "name"
      }, " Vendor Name: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        id: "name",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.name[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.name[0]', ''),
        value: this.state.name,
        onChange: function onChange(e) {
          _this4.setState({
            name: e.target.value
          });
        },
        placeholder: "Name of the vendor"
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "name"
      }, " Vendor Code: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        id: "name",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.code[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.code[0]', ''),
        value: this.state.code,
        onChange: function onChange(e) {
          _this4.setState({
            code: e.target.value
          });
        },
        placeholder: "Code of the vendor"
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "address"
      }, " Vendor Address: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        id: "address",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.address[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.address[0]', ''),
        value: this.state.address,
        onChange: function onChange(e) {
          _this4.setState({
            address: e.target.value
          });
        },
        placeholder: "Address of the vendor"
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "contact_persons"
      }, " Contact Persons: "), this.state.contact_persons.map(function (contact_person) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          key: contact_person.key
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group mt-2"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
          isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".name"), 0], false),
          value: _this4.state.contact_persons.find(function (cp) {
            return cp.key == contact_person.key;
          }).name,
          onChange: function onChange(e) {
            var name = e.target.value;

            _this4.setState(function (prevState) {
              return {
                contact_persons: prevState.contact_persons.map(function (cp) {
                  if (cp.key == contact_person.key) {
                    return _objectSpread({}, cp, {
                      name: name
                    });
                  }

                  return cp;
                })
              };
            });
          },
          placeholder: "Name"
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
          isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".phone"), 0], false),
          value: _this4.state.contact_persons.find(function (cp) {
            return cp.key == contact_person.key;
          }).phone,
          onChange: function onChange(e) {
            var phone = e.target.value;

            _this4.setState(function (prevState) {
              return {
                contact_persons: prevState.contact_persons.map(function (cp) {
                  if (cp.key == contact_person.key) {
                    return _objectSpread({}, cp, {
                      phone: phone
                    });
                  }

                  return cp;
                })
              };
            });
          },
          placeholder: "Phone"
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group-append"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
          onClick: function onClick() {
            _this4.onClickRemoveContactPersonButton(contact_person.key);
          },
          type: "button",
          className: "btn btn-outline-danger btn-sm"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
          className: "fa fa-times"
        })))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "text-danger"
        }, Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".name"), 0], false) || ''), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "text-danger"
        }, Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this4.state.errorData, ['errors', "contact_people.".concat(contact_person.key, ".phone"), 0], false) || '')));
      }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right mt-2"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        onClick: this.onClickAddContactPersonButton,
        type: "button",
        className: "btn btn-sm btn-default"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      }))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right mt-3"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        className: "btn btn-primary btn-sm"
      }, "Create Vendor", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      })))));
    }
  }]);

  return CreateVendorForm;
}(react__WEBPACK_IMPORTED_MODULE_0___default.a.Component);

var rootElem = document.getElementById('create-vendor-form');

if (rootElem) {
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(CreateVendorForm, null), rootElem);
}

/***/ }),

/***/ "./resources/assets/js/components/DeliveryOrderInputForm.jsx":
/*!*******************************************************************!*\
  !*** ./resources/assets/js/components/DeliveryOrderInputForm.jsx ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DeliveryOrderInputForm; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _SelectFormControl__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./SelectFormControl */ "./resources/assets/js/components/SelectFormControl.jsx");
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }









var DeliveryOrderInputForm =
/*#__PURE__*/
function (_Component) {
  _inherits(DeliveryOrderInputForm, _Component);

  function DeliveryOrderInputForm(props) {
    var _this;

    _classCallCheck(this, DeliveryOrderInputForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(DeliveryOrderInputForm).call(this, props));
    _this.keyCounter = 0;
    _this.state = {
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
    _this.handleVendorSelectionChange = _this.handleVendorSelectionChange.bind(_assertThisInitialized(_this));
    _this.handleVendorItemSelectionChange = _this.handleVendorItemSelectionChange.bind(_assertThisInitialized(_this));
    _this.handleAddItem = _this.handleAddItem.bind(_assertThisInitialized(_this));
    _this.handleItemQuantityChange = _this.handleItemQuantityChange.bind(_assertThisInitialized(_this));
    _this.handleUnpickItem = _this.handleUnpickItem.bind(_assertThisInitialized(_this));
    _this.handleFormSubmit = _this.handleFormSubmit.bind(_assertThisInitialized(_this));
    _this.getFormData = _this.getFormData.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(DeliveryOrderInputForm, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      axios__WEBPACK_IMPORTED_MODULE_2___default.a.get("/user/index").then(function (response) {
        _this2.setState({
          users: response.data,
          selected_receiver: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(response.data, '[0].id', '')
        });
      });
      axios__WEBPACK_IMPORTED_MODULE_2___default.a.get("/storage/index").then(function (response) {
        _this2.setState({
          storages: response.data,
          selected_storage: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(response.data, '[0].id', '')
        });
      });
      axios__WEBPACK_IMPORTED_MODULE_2___default.a.get("/vendor/index").then(function (response) {
        _this2.setState({
          vendors: response.data,
          selected_vendor: response.data[0].id
        });

        if (response.data.length == 0) return;
        axios__WEBPACK_IMPORTED_MODULE_2___default.a.get("/vendor/item/".concat(response.data[0].id)).then(function (response) {
          response.data = response.data.sort(function (a, b) {
            return a.name.localeCompare(b);
          });
          var items = response.data;

          _this2.setState({
            vendor_items: items,
            selected_vendor_item: response.data[0].id,
            firstTimeLoadFinished: true
          });
        });
      });
    }
  }, {
    key: "getFormData",
    value: function getFormData() {
      var grouped = Object(lodash__WEBPACK_IMPORTED_MODULE_3__["groupBy"])(this.state.picked_vendor_items, 'id');
      var delivery_items = Object.keys(grouped).map(function (key) {
        var temp = {};
        temp.id = key;
        temp.quantity = grouped[key].map(function (item) {
          return item.quantity;
        }).reduce(function (acc, val) {
          return acc + parseFloat(val);
        }, 0);
        return temp;
      });
      return {
        received_at: this.state.selected_date,
        receiver_id: this.state.selected_receiver,
        source_id: this.state.selected_vendor,
        target_id: this.state.selected_storage,
        delivery_items: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["keyBy"])(delivery_items, 'id')
      };
    }
  }, {
    key: "handleFormSubmit",
    value: function handleFormSubmit(e) {
      var _this3 = this;

      e.preventDefault();
      axios__WEBPACK_IMPORTED_MODULE_2___default.a.post("/delivery_order/create", this.getFormData()).then(function (response) {
        window.location.replace(response.data.redirect);
      })["catch"](function (error) {
        if (error.response.data) {
          _this3.setState({
            errorData: error.response.data
          });

          return;
        }

        alert('Form submit failed.');
      });
    }
  }, {
    key: "handleVendorSelectionChange",
    value: function handleVendorSelectionChange(e) {
      var _this4 = this;

      this.setState({
        selected_vendor: e.target.value
      });
      axios__WEBPACK_IMPORTED_MODULE_2___default.a.get("/vendor/item/".concat(e.target.value)).then(function (response) {
        var selected_vendor_item = response.data[0] ? response.data[0].id : '';

        _this4.setState({
          vendor_items: response.data,
          selected_vendor_item: selected_vendor_item
        });
      });
    }
  }, {
    key: "handleVendorItemSelectionChange",
    value: function handleVendorItemSelectionChange(e) {
      this.setState({
        selected_vendor_item: e.target.value
      });
    }
  }, {
    key: "handleAddItem",
    value: function handleAddItem() {
      var _this5 = this;

      var selected_item = this.state.vendor_items.find(function (item) {
        return item.id == _this5.state.selected_vendor_item;
      });

      var picked_vendor_item = _objectSpread({
        key: this.keyCounter++
      }, selected_item, {
        quantity: 1
      });

      var picked_vendor_items = [].concat(_toConsumableArray(this.state.picked_vendor_items), [picked_vendor_item]);
      this.setState({
        picked_vendor_items: picked_vendor_items
      });
    }
  }, {
    key: "handleItemQuantityChange",
    value: function handleItemQuantityChange(key, value) {
      this.setState({
        picked_vendor_items: this.state.picked_vendor_items.map(function (item) {
          if (key == item.key) {
            return _objectSpread({}, item, {
              quantity: value
            });
          }

          return item;
        })
      });
    }
  }, {
    key: "handleUnpickItem",
    value: function handleUnpickItem(item_id) {
      var items = this.state.picked_vendor_items.filter(function (item) {
        return item.key != item_id;
      });
      this.setState({
        picked_vendor_items: items
      });
    }
  }, {
    key: "renderItemSelections",
    value: function renderItemSelections() {
      if (this.state.firstTimeLoadFinished && this.state.vendor_items.length == 0) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "alert alert-warning"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
          className: "fa fa-warning mr-2"
        }), "There are no vendor items at all.");
      }

      var delivery_item_error = Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.delivery_items[0]', false);
      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "input-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
        onChange: this.handleVendorItemSelectionChange,
        value: this.state.selected_vendor_item,
        className: "custom-select"
      }, this.state.vendor_items.map(function (item) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
          value: item.id,
          key: item.id
        }, " ", item.name, " (", item.unit, ") ");
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "input-group-append"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        type: "button",
        onClick: this.handleAddItem,
        className: "btn btn-secondary"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      })))), delivery_item_error && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "mt-2 alert alert-danger"
      }, delivery_item_error));
    }
  }, {
    key: "renderSelectedItems",
    value: function renderSelectedItems() {
      var _this6 = this;

      return this.state.picked_vendor_items.map(function (item) {
        var quantityError = Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this6.state.errorData, ['errors', "delivery_items.".concat(item.id, ".quantity"), '0'], false);
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0__["Fragment"], {
          key: item.key
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group input-group-sm mt-2"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group-prepend"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
          style: {
            width: '24rem'
          },
          className: "input-group-text"
        }, item.name, " (", item.unit, ")")), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
          className: classnames__WEBPACK_IMPORTED_MODULE_4___default()('form-control', {
            'is-invalid': quantityError
          }),
          onChange: function onChange(e) {
            _this6.handleItemQuantityChange(item.key, e.target.value);
          },
          type: "number",
          step: "0.001",
          value: item.quantity
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
          className: "input-group-append"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
          type: "button",
          onClick: function onClick() {
            _this6.handleUnpickItem(item.key);
          },
          className: "btn btn-sm btn-outline-danger"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
          className: "fa fa-times"
        })))), quantityError && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
          className: "text-danger"
        }, quantityError));
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this7 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.handleFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, " Receiver: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_SelectFormControl__WEBPACK_IMPORTED_MODULE_5__["default"], {
        value: this.state.selected_receiver,
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.receiver_id[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.receiver_id[0]', ''),
        options: this.state.users.map(function (user) {
          return {
            value: user.id,
            key: user.id,
            name: user.name
          };
        }),
        onChange: function onChange(e) {
          _this7.setState({
            selected_receiver: e.target.value
          });
        }
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: ""
      }, " Storage: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_SelectFormControl__WEBPACK_IMPORTED_MODULE_5__["default"], {
        value: this.state.selected_storage,
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.target_id[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.target_id[0]', ''),
        options: this.state.storages.map(function (storage) {
          return {
            value: storage.id,
            key: storage.id,
            name: storage.name
          };
        }),
        onChange: function onChange(e) {
          _this7.setState({
            selected_storage: e.target.value
          });
        }
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, " Receivement Date: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_6__["default"], {
        type: "date",
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.received_at[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.received_at[0]', ''),
        value: this.state.selected_date,
        onChange: function onChange(e) {
          _this7.setState({
            selected_date: e.target.value
          });
        }
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: ""
      }, " Vendor: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_SelectFormControl__WEBPACK_IMPORTED_MODULE_5__["default"], {
        value: this.state.selected_vendor,
        disabled: this.state.picked_vendor_items.length != 0,
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.target_id[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.target_id[0]', ''),
        options: this.state.vendors.map(function (item) {
          return {
            value: item.id,
            key: item.id,
            name: item.name
          };
        }),
        onChange: this.handleVendorSelectionChange
      })), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, " Vendor Items: "), this.renderItemSelections()), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, " Selected Items: "), this.renderSelectedItems()), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right mt-4"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        className: "btn btn-primary btn-sm"
      }, "Create Delivery Order", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-plus"
      }))));
    }
  }]);

  return DeliveryOrderInputForm;
}(react__WEBPACK_IMPORTED_MODULE_0__["Component"]);



if (document.getElementById('delivery-order-input-form')) {
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(DeliveryOrderInputForm, null), document.getElementById('delivery-order-input-form'));
}

/***/ }),

/***/ "./resources/assets/js/components/InputFormControl.jsx":
/*!*************************************************************!*\
  !*** ./resources/assets/js/components/InputFormControl.jsx ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }




function InputFormControl(_ref) {
  var isInvalid = _ref.isInvalid,
      invalidFeedback = _ref.invalidFeedback,
      dataType = _ref.dataType,
      props = _objectWithoutProperties(_ref, ["isInvalid", "invalidFeedback", "dataType"]);

  var class_names = classnames__WEBPACK_IMPORTED_MODULE_1___default()(_objectSpread({
    'form-control': true
  }, props.className, {
    'is-invalid': isInvalid
  }));
  return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({}, props, {
    className: class_names
  })), isInvalid && invalidFeedback && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, invalidFeedback)));
}

/* harmony default export */ __webpack_exports__["default"] = (InputFormControl);

/***/ }),

/***/ "./resources/assets/js/components/SelectFormControl.jsx":
/*!**************************************************************!*\
  !*** ./resources/assets/js/components/SelectFormControl.jsx ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }




function SelectFormControl(_ref) {
  var value = _ref.value,
      options = _ref.options,
      isInvalid = _ref.isInvalid,
      invalidFeedback = _ref.invalidFeedback,
      className = _ref.className,
      props = _objectWithoutProperties(_ref, ["value", "options", "isInvalid", "invalidFeedback", "className"]);

  var class_names = classnames__WEBPACK_IMPORTED_MODULE_1___default()(_objectSpread({
    'custom-select': true
  }, className, {
    'is-invalid': isInvalid
  }));
  var defaultInvalidFeedback = isInvalid && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, " ", invalidFeedback, " "));
  return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", _extends({
    value: value,
    className: class_names
  }, props), options.map(function (option) {
    return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
      value: option.value,
      key: option.key
    }, " ", option.name, " ");
  })), defaultInvalidFeedback);
}

/* harmony default export */ __webpack_exports__["default"] = (SelectFormControl);

/***/ }),

/***/ "./resources/assets/js/components/UpdateDeliveryOrderPricesForm.jsx":
/*!**************************************************************************!*\
  !*** ./resources/assets/js/components/UpdateDeliveryOrderPricesForm.jsx ***!
  \**************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }







var UpdateDeliveryOrderPricesForm =
/*#__PURE__*/
function (_React$Component) {
  _inherits(UpdateDeliveryOrderPricesForm, _React$Component);

  function UpdateDeliveryOrderPricesForm(props) {
    var _this;

    _classCallCheck(this, UpdateDeliveryOrderPricesForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(UpdateDeliveryOrderPricesForm).call(this, props));
    _this.keyCounter = 0;
    _this.state = {
      delivery_order_items: {},
      errorData: {}
    };
    _this.onFormSubmit = _this.onFormSubmit.bind(_assertThisInitialized(_this));
    _this.mapStateToFormData = _this.mapStateToFormData.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(UpdateDeliveryOrderPricesForm, [{
    key: "mapStateToFormData",
    value: function mapStateToFormData() {
      var _this2 = this;

      return {
        delivery_order_items: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["keyBy"])(Object.keys(this.state.delivery_order_items).map(function (key) {
          var do_items = _this2.state.delivery_order_items;
          return {
            id: do_items[key].id,
            price: do_items[key].price
          };
        }), 'id')
      };
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this3 = this;

      axios__WEBPACK_IMPORTED_MODULE_4___default.a.get(window.location.href).then(function (response) {
        _this3.setState({
          delivery_order_items: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["keyBy"])(response.data, 'id')
        });
      })["catch"]();
    }
  }, {
    key: "onFormSubmit",
    value: function onFormSubmit(e) {
      var _this4 = this;

      e.preventDefault();
      axios__WEBPACK_IMPORTED_MODULE_4___default.a.post(window.location.href, this.mapStateToFormData()).then(function (response) {
        if (response.data.redirect) {
          window.location.replace(response.data.redirect);
        }
      })["catch"](function (error) {
        _this4.setState({
          errorData: error.response.data
        });
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this5 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.onFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "table-responsive"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("table", {
        className: "table table-sm table-striped"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("thead", {
        className: "thead-dark"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, " # "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, " Item "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, " Quantity "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, " Unit "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
        className: "text-right"
      }, " Price "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
        className: "text-right"
      }, " Subtotal "))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tbody", null, Object.keys(this.state.delivery_order_items).map(function (key, i) {
        var do_items = _this5.state.delivery_order_items;
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
          key: i
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, " ", i + 1, ". "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, " ", do_items[key].item.name, " "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, " ", do_items[key].quantity, " "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, " ", do_items[key].item.unit, " "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
          className: "text-right"
        }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
          className: {
            'form-control-sm': true,
            'text-right': true
          },
          type: "number",
          step: "0.001",
          placeholder: "Price",
          isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this5.state.errorData, ['errors', "delivery_order_items.".concat(key, ".price"), 0], false),
          invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(_this5.state.errorData, ['errors', "delivery_order_items.".concat(key, ".price"), 0], ''),
          value: parseFloat(do_items[key].price),
          onChange: function onChange(e) {
            var newPrice = e.target.value;

            _this5.setState(function (prevState) {
              var updated = {};
              updated[key] = _objectSpread({}, do_items[key], {
                price: newPrice
              });
              return {
                delivery_order_items: _objectSpread({}, prevState.delivery_order_items, {}, updated)
              };
            });
          }
        }), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
          type: "button",
          onClick: function onClick(e) {
            var copied = _objectSpread({}, _this5.state.delivery_order_items);

            copied[key] = _objectSpread({}, do_items[key], {
              price: do_items[key].latest_price
            });

            _this5.setState({
              delivery_order_items: copied
            });
          },
          className: "btn btn-dark btn-sm d-inline-block mt-1"
        }, "Use Latest Price: ", parseFloat(do_items[key].latest_price).toLocaleString('id-ID'))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
          className: "text-right"
        }, (do_items[key].price * do_items[key].quantity).toLocaleString('id-ID')));
      })))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        className: "btn btn-primary btn-sm"
      }, "Update", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-check"
      }))));
    }
  }]);

  return UpdateDeliveryOrderPricesForm;
}(react__WEBPACK_IMPORTED_MODULE_0___default.a.Component);

var rootElem = document.getElementById('update-delivery-order-prices-form');

if (rootElem) {
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(UpdateDeliveryOrderPricesForm, null), rootElem);
}

/***/ }),

/***/ "./resources/assets/js/components/UpdateInvoicePaymentForm.jsx":
/*!*********************************************************************!*\
  !*** ./resources/assets/js/components/UpdateInvoicePaymentForm.jsx ***!
  \*********************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "./node_modules/react-dom/index.js");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _InputFormControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputFormControl */ "./resources/assets/js/components/InputFormControl.jsx");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }







var UpdateInvoicePaymentForm =
/*#__PURE__*/
function (_Component) {
  _inherits(UpdateInvoicePaymentForm, _Component);

  function UpdateInvoicePaymentForm(props) {
    var _this;

    _classCallCheck(this, UpdateInvoicePaymentForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(UpdateInvoicePaymentForm).call(this, props));
    _this.payment_methods = [{
      name: 'cash',
      label: 'Cash'
    }, {
      name: 'new_giro',
      label: 'New Giro'
    }, {
      name: 'giro',
      label: 'Old Giro'
    }];
    _this.state = {
      selected_payment_method: 'cash',
      giro_options: [],
      cash_amount: '',
      giro_number: '',
      selected_giro_option: '',
      errorData: {}
    };
    _this.onPaymentMethodChange = _this.onPaymentMethodChange.bind(_assertThisInitialized(_this));
    _this.onGiroFilterChange = _this.onGiroFilterChange.bind(_assertThisInitialized(_this));
    _this.onGiroSelectChange = _this.onGiroSelectChange.bind(_assertThisInitialized(_this));
    _this.debouncedLoadGiroOptions = Object(lodash__WEBPACK_IMPORTED_MODULE_3__["debounce"])(_this.loadGiroOptions.bind(_assertThisInitialized(_this)), 400);
    _this.onFormSubmit = _this.onFormSubmit.bind(_assertThisInitialized(_this));
    _this.getFormData = _this.getFormData.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(UpdateInvoicePaymentForm, [{
    key: "getFormData",
    value: function getFormData() {
      return {
        payment_method: this.state.selected_payment_method,
        cash_amount: this.state.cash_amount,
        giro_number: this.state.giro_number,
        giro_id: this.state.selected_giro_option
      };
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      this.loadGiroOptions('');
    }
  }, {
    key: "onPaymentMethodChange",
    value: function onPaymentMethodChange(e) {
      this.setState({
        selected_payment_method: e.target.value
      });
    }
  }, {
    key: "onGiroFilterChange",
    value: function onGiroFilterChange(e) {
      this.debouncedLoadGiroOptions(e.target.value);
    }
  }, {
    key: "onGiroSelectChange",
    value: function onGiroSelectChange(e) {
      this.setState({
        selected_giro_option: e.target.value
      });
    }
  }, {
    key: "loadGiroOptions",
    value: function loadGiroOptions(filter) {
      var _this2 = this;

      axios__WEBPACK_IMPORTED_MODULE_4___default.a.get("/giro/search?number=".concat(filter)).then(function (response) {
        var new_selected_giro_option = response.data[0] ? response.data[0].id : '';

        _this2.setState({
          giro_options: response.data,
          selected_giro_option: new_selected_giro_option
        });
      })["catch"](function (error) {});
    }
  }, {
    key: "onFormSubmit",
    value: function onFormSubmit(e) {
      var _this3 = this;

      e.preventDefault();
      axios__WEBPACK_IMPORTED_MODULE_4___default.a.post("/invoice/pay/".concat(this.props.invoiceId), this.getFormData()).then(function (response) {
        window.location.replace(response.data.redirect);
      })["catch"](function (error) {
        _this3.setState({
          errorData: error.response.data
        });
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this4 = this;

      return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
        onSubmit: this.onFormSubmit
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "payment_method"
      }, " Payment Method: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
        className: "form-control form-control-sm",
        value: this.state.selected_payment_method,
        onChange: this.onPaymentMethodChange,
        name: "payment_method",
        id: "payment_method"
      }, this.payment_methods.map(function (method) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
          key: method.name,
          value: method.name
        }, " ", method.label, " ");
      }))), this.state.selected_payment_method == 'new_giro' && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "giro_number"
      }, " Giro Number: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        isInvalid: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.giro_number[0]', false),
        invalidFeedback: Object(lodash__WEBPACK_IMPORTED_MODULE_3__["get"])(this.state.errorData, 'errors.giro_number[0]', ''),
        value: this.state.giro_number,
        onChange: function onChange(e) {
          _this4.setState({
            giro_number: e.target.value
          });
        },
        className: {
          'form-control-sm': true
        },
        placeholder: "Giro number"
      })), this.state.selected_payment_method == 'giro' && react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "alert alert-info"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "giro_number_filter"
      }, " Filter Selection By Giro Number: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_InputFormControl__WEBPACK_IMPORTED_MODULE_2__["default"], {
        onChange: this.onGiroFilterChange,
        className: {
          'form-control-sm': true
        },
        placeholder: "Giro number"
      }))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "form-group"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
        htmlFor: "giro_id"
      }, " Giro Number: "), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
        value: this.state.selected_giro_option,
        onChange: this.onGiroSelectChange,
        className: "form-control form-control-sm",
        name: "giro_id",
        id: "giro_id"
      }, this.state.giro_options.map(function (giro) {
        return react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
          key: giro.id,
          value: giro.id
        }, " ", giro.number, " ");
      })))), react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: "text-right"
      }, react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
        className: "btn btn-primary btn-sm"
      }, "Update Payment", react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
        className: "fa fa-usd"
      }))));
    }
  }]);

  return UpdateInvoicePaymentForm;
}(react__WEBPACK_IMPORTED_MODULE_0__["Component"]);

var rootElem = document.getElementById('update-invoice-payment-form');

if (rootElem) {
  var invoiceId = document.getElementById('invoice-id').dataset.invoiceId;
  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render(react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(UpdateInvoicePaymentForm, {
    invoiceId: invoiceId
  }), rootElem);
}

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./resources/assets/js/app.js ./resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/atomicbomber/projects/property_developer_information_system/resources/assets/js/app.js */"./resources/assets/js/app.js");
module.exports = __webpack_require__(/*! /home/atomicbomber/projects/property_developer_information_system/resources/assets/sass/app.scss */"./resources/assets/sass/app.scss");


/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);