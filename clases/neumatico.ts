namespace Entidades
{
    export class Neumatico
    {
        protected marca : string;
        protected medidas : string;
        protected precio : number;

        public constructor(marca : string, medidas : string, precio : number)
        {
            this.marca = marca;
            this.medidas = medidas;
            this.precio = precio;
        }

        public ToString() : string
        {
            return `"marca":"${this.marca}","medidas":"${this.medidas}","precio":${this.precio}`;
        }

        public ToJSON() : string
        {
            return `{${this.ToString()}}`;
        }
    }
}