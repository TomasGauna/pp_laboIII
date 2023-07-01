"use strict";
class Ajax {
    constructor() {
        this.Get = (ruta, success, params = "", error) => {
            let parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            this._xhr.open('GET', ruta);
            this._xhr.send();
            this._xhr.onreadystatechange = () => {
                if (this._xhr.readyState === Ajax.DONE) {
                    if (this._xhr.status === Ajax.OK) {
                        success(this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = (ruta, success, params = "", form, error) => {
            let parametros = params.length > 0 ? params : "";
            let esForm = form !== undefined ? true : false;
            this._xhr.open('POST', ruta, true);
            if (!esForm) {
                this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                this._xhr.send(parametros);
            }
            else {
                this._xhr.send(form);
            }
            this._xhr.onreadystatechange = () => {
                if (this._xhr.readyState === Ajax.DONE) {
                    if (this._xhr.status === Ajax.OK) {
                        success(this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(this._xhr.status);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    AgregarAlEventoOnReady(funcion) {
        this._xhr.onreadystatechange = () => { funcion(); };
    }
}
//# sourceMappingURL=ajax.js.map