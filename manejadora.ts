/// <reference path = "./clases/neumatico.ts"/>
/// <reference path = "./clases/neumaticoBD.ts"/>

namespace PrimerParcial
{
    export class Manejadora implements Entidades.Iparte2
    {
        public static AgregarNeumaticoJSON() : void
        {
            let ruta = "./BACKEND/altaNeumaticoJSON.php";
            let marca = (<HTMLInputElement>document.getElementById("marca")).value;
            let medidas = (<HTMLInputElement>document.getElementById("medidas")).value;
            let precio = (<HTMLInputElement>document.getElementById("precio")).value;

            let ajax = new Ajax();
            let form = new FormData();
            
            form.append('marca', marca);
            form.append('medidas', medidas);
            form.append('precio', precio);

            ajax.Post(ruta, (resultado : string)=>
            {
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, "", form);
        }

        public static MostrarNeumaticosJSON() : void
        {
            let ajax = new Ajax();

            ajax.Get("./BACKEND/ListadoNeumaticosJSON.php", (resultado : string)=>
            {
                (<HTMLDivElement>document.getElementById("divTabla")).textContent = "";
                let neumaticos = JSON.parse(resultado);
                console.clear();
                console.log(resultado);
                if(neumaticos !== null)
                {
                    let div = (<HTMLDivElement>document.getElementById("divTabla"));
                    let tablaHTML = '<table><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>';

                    for (let neumatico of neumaticos) 
                    {
                        tablaHTML += '<tr><td>' + neumatico.marca + '</td><td>' + neumatico.medidas + '</td><td>' + neumatico.precio + '</td></tr>';
                    }

                    tablaHTML += '</tbody></table>';

                    div.innerHTML = tablaHTML;
                }
                else
                {
                    console.log("Error...");
                }

            })
        }

        public static VerificarNeumaticoJSON() : void
        {
            let ruta = "./BACKEND/verificarNeumaticoJSON.php";
            let marca = (<HTMLInputElement>document.getElementById("marca")).value;
            let medidas = (<HTMLInputElement>document.getElementById("medidas")).value;

            let ajax = new Ajax();
            let form = new FormData();
            
            form.append('marca', marca);
            form.append('medidas', medidas);


            ajax.Post(ruta, (resultado : string)=>
            {
                console.clear();
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, "", form);
        }

        public static AgregarNeumaticoSinFoto() : void
        {
            let ruta = "./BACKEND/agregarNeumaticoSinFoto.php";
            let marca = (<HTMLInputElement>document.getElementById("marca")).value;
            let medidas = (<HTMLInputElement>document.getElementById("medidas")).value;
            let precio = (<HTMLInputElement>document.getElementById("precio")).value;

            let params = "neumatico_json=" + `${new Entidades.Neumatico(marca,medidas,parseInt(precio)).ToJSON()}`;
            let ajax = new Ajax();
         
            ajax.Post(ruta, (resultado : string)=>
            {
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, params);
        }

        public static MostrarNeumaticosBD() : void
        {
            let ruta = "./BACKEND/listadoNeumaticosBD.php";
            let ajax = new Ajax();

            ajax.Get(ruta, (resultado : string)=>
            {
                let neumaticos = JSON.parse(resultado);
                console.clear();
                console.log(resultado);
                if(neumaticos !== null)
                {
                    let div = (<HTMLDivElement>document.getElementById("divTabla"));
                    let tabla = document.createElement("tabla");
                    let cabecera = document.createElement("tr");
                    let celdaID = document.createElement("th");
                    let celdaMarca = document.createElement("th");
                    let celdaMedidas = document.createElement("th");
                    let celdaPrecio = document.createElement("th");
                    let celdaFoto = document.createElement("th");
                    let celdaAccion = document.createElement("th");

                    celdaID.textContent = "ID";
                    celdaMarca.textContent = "Marca";
                    celdaMedidas.textContent = "Medidas";
                    celdaPrecio.textContent = "Precio";
                    celdaFoto.textContent = "Foto";
                    celdaAccion.textContent = "Accion";
                    cabecera.appendChild(celdaID);
                    cabecera.appendChild(celdaMarca);
                    cabecera.appendChild(celdaMedidas);
                    cabecera.appendChild(celdaPrecio);
                    cabecera.appendChild(celdaFoto);
                    cabecera.appendChild(celdaAccion);

                    tabla.appendChild(cabecera);

                    for(let neumatico of neumaticos)
                    {
                        let fila = document.createElement("tr");
                        let celdaID = document.createElement("td");
                        let celdaMarca = document.createElement("td");
                        let celdaMedidas = document.createElement("td");
                        let celdaPrecio = document.createElement("td");
                        let celdaFoto = document.createElement("td");
                        let celdaAccion = document.createElement("td");
                        let btnEliminar = document.createElement("button");
                        let btnModificar = document.createElement("button");

                        celdaID.textContent = neumatico.id;
                        celdaMarca.textContent = neumatico.marca;
                        celdaMedidas.textContent = neumatico.medidas;
                        celdaPrecio.textContent = neumatico.precio;
                        celdaFoto.innerHTML = `<img src="./BACKEND/${neumatico.pathFoto}" width="50" height="50">`;

                        btnEliminar.classList.add('btn','btn-danger');
                        btnEliminar.setAttribute('data-obj', neumatico);
                        btnEliminar.setAttribute('name', 'btnEliminar');
                        btnEliminar.innerHTML = '<span class="bi bi-x-circle"></span>';
                        btnEliminar.addEventListener("click", () => 
                        {
                            (new Manejadora()).EliminarNeumatico(JSON.stringify(neumatico));////////////////////VER ESTO
                            console.log("Eliminar neumático con ID:", neumatico.id);
                        });

                        btnModificar.classList.add('btn','btn-info');
                        btnModificar.setAttribute('data-obj', neumatico);
                        btnModificar.setAttribute('name', 'btnModificar');
                        btnModificar.innerHTML = '<span class="bi bi-pencil"></span>';
                        btnModificar.addEventListener("click", () => 
                        {
                            (new Manejadora()).EliminarNeumatico(JSON.stringify(neumatico));
                            console.log("Modificar neumático con ID:", neumatico.id);
                        });

                        celdaAccion.appendChild(btnEliminar);
                        celdaAccion.appendChild(btnModificar);

                        fila.appendChild(celdaID);
                        fila.appendChild(celdaMarca);
                        fila.appendChild(celdaMedidas);
                        fila.appendChild(celdaPrecio);
                        fila.appendChild(celdaFoto);
                        fila.appendChild(celdaAccion);

                        tabla.appendChild(fila);
                    }
                            
                    div.appendChild(tabla);
                }
                else
                {
                    console.log("Error...");
                }
            });
        }

        EliminarNeumatico(params : string) : void 
        {
            let obj = JSON.parse(params);
            if(prompt(`Está seguro de eliminar ${obj.marca} - ${obj.medidas}? 's' para confirmar, otro para denegar.`) === "s")
            {
                let ajax = new Ajax();

                ajax.Post("./BACKEND/eliminarNeumaticoBD.php", (resultado : string)=>
                {
                    let retornoParseado = JSON.parse(resultado);
                    console.clear();
                    console.log(retornoParseado.mensaje);
                    alert(retornoParseado.mensaje);
                    
                    if(retornoParseado.exito)
                    {
                        ajax.AgregarAlEventoOnReady(()=>
                        {
                            let div = (<HTMLDivElement>document.getElementById("divTabla"));
                            div.textContent = "";
                        });
                    }
                }, params);
            }
        }
        ModificarNeumatico(params : string) : void 
        {
            throw new Error("Method not implemented.");
        }

    }
}