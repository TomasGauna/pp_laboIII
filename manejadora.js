"use strict";
/// <reference path = "./clases/neumatico.ts"/>
/// <reference path = "./clases/neumaticoBD.ts"/>
var PrimerParcial;
(function (PrimerParcial) {
    class Manejadora {
        static AgregarNeumaticoJSON() {
            let ruta = "./BACKEND/altaNeumaticoJSON.php";
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            let precio = document.getElementById("precio").value;
            let ajax = new Ajax();
            let form = new FormData();
            form.append('marca', marca);
            form.append('medidas', medidas);
            form.append('precio', precio);
            ajax.Post(ruta, (resultado) => {
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, "", form);
        }
        static MostrarNeumaticosJSON() {
            let ajax = new Ajax();
            ajax.Get("./BACKEND/ListadoNeumaticosJSON.php", (resultado) => {
                document.getElementById("divTabla").textContent = "";
                let neumaticos = JSON.parse(resultado);
                console.clear();
                console.log(resultado);
                if (neumaticos !== null) {
                    let div = document.getElementById("divTabla");
                    //let tabla = document.createElement("tabla");
                    //let cabecera = document.createElement("tr");
                    //let celdaMarca = document.createElement("th");
                    //let celdaMedidas = document.createElement("th");
                    //let celdaPrecio = document.createElement("th");
                    //celdaMarca.textContent = "Marca";
                    //celdaMedidas.textContent = "Medidas";
                    //celdaPrecio.textContent = "Precio";
                    //cabecera.appendChild(celdaMarca);
                    //cabecera.appendChild(celdaMedidas);
                    //cabecera.appendChild(celdaPrecio);
                    //tabla.appendChild(cabecera);
                    //div.innerText = "";
                    //div.innerHTML = "";
                    //div.innerHTML = '<table><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>'//<tr><td></td><td></td></tr>'
                    //for(let neumatico of neumaticos)
                    //{
                    //    div.innerHTML += '<tr><td>' + neumatico.marca + '</td><td>' + neumatico.medidas + '</td><td>' + neumatico.precio + '</td></tr>';
                    //}
                    //div.innerHTML += "</tbody></table>";
                    //div.innerHTML = '<table><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>';
                    let tablaHTML = '<table><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>';
                    for (let neumatico of neumaticos) {
                        tablaHTML += '<tr><td>' + neumatico.marca + '</td><td>' + neumatico.medidas + '</td><td>' + neumatico.precio + '</td></tr>'; //'<tr><td>' + neumatico.marca + '</td><td>' + neumatico.medidas + '</td><td>' + neumatico.precio + '</td></tr>';
                    }
                    tablaHTML += '</tbody></table>';
                    div.innerHTML = tablaHTML;
                }
                else {
                    console.log("Error...");
                }
            });
        }
        static VerificarNeumaticoJSON() {
            let ruta = "./BACKEND/verificarNeumaticoJSON.php";
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            let ajax = new Ajax();
            let form = new FormData();
            form.append('marca', marca);
            form.append('medidas', medidas);
            ajax.Post(ruta, (resultado) => {
                console.clear();
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, "", form);
        }
        static AgregarNeumaticoSinFoto() {
            let ruta = "./BACKEND/agregarNeumaticoSinFoto.php";
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            let precio = document.getElementById("precio").value;
            let params = "neumatico_json=" + `${new Entidades.Neumatico(marca, medidas, parseInt(precio)).ToJSON()}`;
            let ajax = new Ajax();
            ajax.Post(ruta, (resultado) => {
                let retornoParseado = JSON.parse(resultado);
                console.log(retornoParseado.mensaje);
                alert(retornoParseado.mensaje);
            }, params);
        }
        static MostrarNeumaticosBD() {
            let ruta = "./BACKEND/listadoNeumaticosBD.php";
            let ajax = new Ajax();
            ajax.Get(ruta, (resultado) => {
                let neumaticos = JSON.parse(resultado);
                console.clear();
                console.log(resultado);
                if (neumaticos !== null) {
                    let div = document.getElementById("divTabla");
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
                    for (let neumatico of neumaticos) {
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
                        btnEliminar.classList.add('btn', 'btn-danger');
                        btnEliminar.setAttribute('data-obj', neumatico);
                        btnEliminar.setAttribute('name', 'btnEliminar');
                        btnEliminar.innerHTML = '<span class="bi bi-x-circle"></span>';
                        btnEliminar.addEventListener("click", () => {
                            (new Manejadora()).EliminarNeumatico(JSON.stringify(neumatico)); ////////////////////VER ESTO
                            console.log("Eliminar neumático con ID:", neumatico.id);
                        });
                        btnModificar.classList.add('btn', 'btn-info');
                        btnModificar.setAttribute('data-obj', neumatico);
                        btnModificar.setAttribute('name', 'btnModificar');
                        btnModificar.innerHTML = '<span class="bi bi-pencil"></span>';
                        btnModificar.addEventListener("click", () => {
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
                else {
                    console.log("Error...");
                }
            });
        }
        EliminarNeumatico(params) {
            let obj = JSON.parse(params);
            if (prompt(`Está seguro de eliminar ${obj.marca} - ${obj.medidas}? 's' para confirmar, otro para denegar.`) === "s") {
                let ajax = new Ajax();
                ajax.Post("./BACKEND/eliminarNeumaticoBD.php", (resultado) => {
                    let retornoParseado = JSON.parse(resultado);
                    console.clear();
                    console.log(retornoParseado.mensaje);
                    alert(retornoParseado.mensaje);
                    if (retornoParseado.exito) {
                        ajax.AgregarAlEventoOnReady(() => {
                            let div = document.getElementById("divTabla");
                            div.textContent = "";
                        });
                    }
                }, params);
            }
        }
        ModificarNeumatico(params) {
            throw new Error("Method not implemented.");
        }
    }
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=manejadora.js.map