"use strict";
/// <reference path= "./neumatico.ts"/>
var Entidades;
(function (Entidades) {
    class NeumaticoBD extends Entidades.Neumatico {
        constructor(marca, medidas, precio, id = 0, pathFoto = "") {
            super(marca, medidas, precio);
            this.id = id;
            this.pathFoto = pathFoto;
        }
        ToJSON() {
            return `{"id":${this.id},${super.ToString()},"pathFoto":"${this.pathFoto}"}`;
        }
    }
    Entidades.NeumaticoBD = NeumaticoBD;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=neumaticoBD.js.map