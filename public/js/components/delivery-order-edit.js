webpackJsonp([2],{

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(66)
/* script */
var __vue_script__ = __webpack_require__(70)
/* template */
var __vue_template__ = __webpack_require__(71)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/vue-components/DeliveryOrderEdit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47e85424", Component.options)
  } else {
    hotAPI.reload("data-v-47e85424", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 66:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 70:
/***/ (function(module, exports) {

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/***/ }),

/***/ 71:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "form",
    {
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.onFormSubmit($event)
        }
      }
    },
    [
      _c(
        "div",
        { staticClass: "form-group" },
        [
          _c("label", { attrs: { for: "receiver_id" } }, [
            _vm._v(" Receiver: ")
          ]),
          _vm._v(" "),
          _c("multiselect", {
            attrs: {
              placeholder: "Receiver",
              "allow-empty": false,
              selectLabel: "",
              selectedLabel: "",
              deselectLabel: "",
              "track-by": "id",
              label: "name",
              options: _vm.users
            },
            model: {
              value: _vm.receiver,
              callback: function($$v) {
                _vm.receiver = $$v
              },
              expression: "receiver"
            }
          }),
          _vm._v(" "),
          _vm.get(this.error_data, "errors.receiver_id[0]", false)
            ? _c("div", { staticClass: "text-danger" }, [
                _vm._v(
                  "\n            " +
                    _vm._s(
                      _vm.get(this.error_data, "errors.receiver_id[0]", false)
                    ) +
                    "\n        "
                )
              ])
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-group" },
        [
          _c("label", { attrs: { for: "storage_id" } }, [_vm._v(" Storage: ")]),
          _vm._v(" "),
          _c("multiselect", {
            attrs: {
              placeholder: "Storage",
              "allow-empty": false,
              selectLabel: "",
              selectedLabel: "",
              deselectLabel: "",
              "track-by": "id",
              label: "name",
              options: _vm.storages
            },
            model: {
              value: _vm.storage,
              callback: function($$v) {
                _vm.storage = $$v
              },
              expression: "storage"
            }
          }),
          _vm._v(" "),
          _vm.get(this.error_data, "errors.storage_id[0]", false)
            ? _c("div", { staticClass: "text-danger" }, [
                _vm._v(
                  "\n            " +
                    _vm._s(
                      _vm.get(this.error_data, "errors.storage_id[0]", false)
                    ) +
                    "\n        "
                )
              ])
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "form-group" }, [
        _c("label", { attrs: { for: "received_at" } }, [
          _vm._v(" Receivement Date: ")
        ]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.received_at,
              expression: "received_at"
            }
          ],
          staticClass: "form-control",
          class: {
            "is-invalid": _vm.get(
              this.error_data,
              "errors.received_at[0]",
              false
            )
          },
          attrs: {
            type: "date",
            id: "received_at",
            placeholder: "Receivement Date"
          },
          domProps: { value: _vm.received_at },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.received_at = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "invalid-feedback" }, [
          _vm._v(
            _vm._s(_vm.get(this.error_data, "errors.received_at[0]", false))
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-group" },
        [
          _c("label", { attrs: { for: "vendor_id" } }, [_vm._v(" Vendor: ")]),
          _vm._v(" "),
          _c("multiselect", {
            attrs: {
              disabled: _vm.picked_items.length > 0,
              placeholder: "Vendor",
              "allow-empty": false,
              selectLabel: "",
              deselectLabel: "",
              "track-by": "id",
              label: "name",
              options: _vm.m_vendors
            },
            model: {
              value: _vm.vendor,
              callback: function($$v) {
                _vm.vendor = $$v
              },
              expression: "vendor"
            }
          }),
          _vm._v(" "),
          _vm.get(this.error_data, "errors.vendor_id[0]", false)
            ? _c("div", { staticClass: "text-danger" }, [
                _vm._v(
                  "\n            " +
                    _vm._s(
                      _vm.get(this.error_data, "errors.vendor_id[0]", false)
                    ) +
                    "\n        "
                )
              ])
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-group" },
        [
          _c("label", [_vm._v(" Item to Add: ")]),
          _vm._v(" "),
          _c("multiselect", {
            attrs: {
              placeholder: "Item",
              "allow-empty": false,
              selectLabel: "",
              selectedLabel: "",
              deselectLabel: "",
              "track-by": "id",
              label: "name",
              options: _vm.item_options,
              "preselect-first": true
            },
            model: {
              value: _vm.selected_item,
              callback: function($$v) {
                _vm.selected_item = $$v
              },
              expression: "selected_item"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "form-group" }, [
        _c("label", [_vm._v(" Item List: ")]),
        _vm._v(" "),
        _vm.picked_items.length > 0
          ? _c(
              "table",
              { staticClass: "table table-sm table-striped table-bordered" },
              [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.picked_items, function(picked_item, i) {
                    return _c("tr", { key: i }, [
                      _c("td", [
                        _vm._v(
                          "\n                        " +
                            _vm._s(picked_item.name) +
                            "\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [_vm._v(" " + _vm._s(picked_item.unit) + " ")]),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model.number",
                              value: picked_item.quantity,
                              expression: "picked_item.quantity",
                              modifiers: { number: true }
                            }
                          ],
                          staticClass: "form-control",
                          class: {
                            "is-invalid": _vm.get(
                              _vm.error_data,
                              ["errors", "items." + i + ".quantity", 0],
                              false
                            )
                          },
                          attrs: {
                            type: "number",
                            id: "picked_item.quantity",
                            placeholder: "Quantity"
                          },
                          domProps: { value: picked_item.quantity },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                picked_item,
                                "quantity",
                                _vm._n($event.target.value)
                              )
                            },
                            blur: function($event) {
                              return _vm.$forceUpdate()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("div", { staticClass: "invalid-feedback" }, [
                          _vm._v(
                            "\n                             " +
                              _vm._s(
                                _vm.get(
                                  _vm.error_data,
                                  ["errors", "items." + i + ".quantity", 0],
                                  false
                                )
                              ) +
                              "\n                        "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            on: {
                              click: function($event) {
                                picked_item.picked = false
                              }
                            }
                          },
                          [_c("i", { staticClass: "fa fa-trash" })]
                        )
                      ])
                    ])
                  }),
                  0
                )
              ]
            )
          : _c("div", { staticClass: "alert alert-warning" }, [
              _c("i", { staticClass: "fa fa-warning" }),
              _vm._v("\n            You haven't picked any item\n        ")
            ])
      ]),
      _vm._v(" "),
      _vm._m(1)
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead thead-dark" }, [
      _c("tr", [
        _c("th", [_vm._v(" Item ")]),
        _vm._v(" "),
        _c("th", [_vm._v(" Unit ")]),
        _vm._v(" "),
        _c("th", [_vm._v(" Quantity ")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v(" Controls ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group d-flex justify-content-end" }, [
      _c("button", { staticClass: "btn btn-primary" }, [
        _vm._v("\n            Store Delivery Order\n        ")
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-47e85424", module.exports)
  }
}

/***/ })

});