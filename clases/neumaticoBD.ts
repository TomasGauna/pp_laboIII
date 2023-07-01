/// <reference path= "./neumatico.ts"/>

namespace Entidades
{
    export class NeumaticoBD extends Neumatico
    {
        private id : number;
        private pathFoto : string;

        public constructor(marca : string, medidas : string, precio : number, id : number = 0, pathFoto : string = "")
        {
            super(marca, medidas, precio);
            this.id = id;
            this.pathFoto = pathFoto;
        }

        public ToJSON(): string 
        {
            return `{"id":${this.id},${super.ToString()},"pathFoto":"${this.pathFoto}"}`;
        }
    }
}