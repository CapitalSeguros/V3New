    // Configuración inicial
    var baseUrlElement = document.getElementById("base_url");//de aqui estoy obteniendo el <?= base_url(); ?>
    if (baseUrlElement) {
      var ruta = baseUrlElement.getAttribute('data-base-url');
      var apiFactura =  ruta + FINAL_URL; // aqui me dice que no esta definida  )
      var apiArchivosEncontrados = ruta + 'presupuestos/ArchivosEncontrados'
    } else {
      console.error('El div "base_url" no se encuentra en el DOM.');
    }
    // Vue 3 usando Options API (como Vue 2)
    // componente vue incorporado por Roberto-Alvarez-12-05-2025---
    // Vue.createApp({
    const app = Vue.createApp({
      data() {
        return {
          factura: [],
          archivosEnCarpeta:[],//
          View:View,
          apiFactura:apiFactura,//para luego pasarselo a vue asi como lo estoy haciendo aqui
          apiArchivosEncontrados:apiArchivosEncontrados,
          ruta:ruta, //ruta dinamica
          baseURL:ruta,
          apiDescargarZip: 'presupuestos/descargarzip',
          rowSeleccionado: null, // Aquí guardarás el ID seleccionado ya sea para eliminar o editar una factura
          mensaje: '',
          buscar:'',
          sugerencias: [],
          vistaPrevia: false,
          archivoNoEncontrado: false,
          urlDelPdf:'',
          contenidoXml: '',
          apiRutaBase:'',
          esXml: false,
          numberFormat: new Intl.NumberFormat('es-MX', { style: 'currency',currency: 'MXN'}),
          columnasVisibles: 
            {
              id: true,
              editar: true,
              fecha_factura: true,
              folio_factura: true,
              fecha_captura: false,
              concepto: true,
              subtotal: true,
              totalfactura: true,
              autorizado: true,
              pagado: true,
              fecha_pago: true,
              validar: false,
              Usuario: false,
              cuentaContable: false,
              personaDepartamento: false,
              nombreProveedor: false,
              tarjeta: false,
              tipo_factura: false,
              Correo_Usuario: false,
              totalSuma:false,
              Accion: false,
              Solicitado_por: false,
              Agregar_PDF: true,
              Agregar_XML: true,
              Comprobante_pago: false,
            },
          botonesSegmentos:{
                                mostrarFechas: true,
                                mostrarFechasServidor: false,
                                mostrarFiltros: true,
                                mostrarBotones: true,
                            },
          fechaInicial: '',
          fechaFinal: '',

        };
      },
      created() {
        this.obtenerFacturas();
        this.vistaVisualizadas();
        // 
      },
      mounted() {
        // Se ejecuta cuando el componente ya está montado
      },
      watch: {
        //=====================================================================================================================
        buscar(nuevaBusqueda) {
          const texto = nuevaBusqueda.toLowerCase().trim();
          if (texto === '') {//si el texto viene vacio no hace nada
            this.sugerencias = [];
            return;
          }
          // Buscar entre todas las propiedades del objeto
          const coincidencias = [];//inicializa coincidencias
          for (const item of this.factura) {
            for (const valor of Object.values(item)) {
              const textoValor = String(valor).toLowerCase();
              if (textoValor.includes(texto) && !coincidencias.includes(valor)) {
                coincidencias.push(valor);
              }
            }
          }

          // Mostrar máximo 3 sugerencias distintas
          this.sugerencias = coincidencias.slice(0, 3);
        },
        //=====================================================================================================================
        fechaInicial(val) {
          if (this.fechaFinal && val > this.fechaFinal) {
            this.fechaFinal = val; // Ajusta automáticamente la fecha final si es menor
          }
        },
        fechaFinal(val) {
          if (this.fechaInicial && val < this.fechaInicial) {
            this.fechaInicial = val; // Ajusta automáticamente la fecha inicial si es mayor
          }
        }
        //=====================================================================================================================
      },
      
      methods: {
        //=====================================================================================================================
        async validarFactura(id) {
          const confirm = await Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Quieres validar esta factura?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, validar',
            cancelButtonText: 'Cancelar'
          });

          if (!confirm.isConfirmed) {
            // Si el usuario cancela, no se hace nada
            return;
          }

          try {
            const response = await fetch(`${this.ruta}presupuestos/ValidaFactura?IDFact=${id}`, {
              method: 'GET',
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            });

            const result = await response.json();

            if (!result.success) throw new Error(result.mensaje || 'Error al validar');

            this.obtenerFacturas();
            Swal.fire("¡Validado!", result.mensaje, "success");

          } catch (error) {
            console.error('Error al validar factura:', error);
            Swal.fire("¡Error!", error.message || "Ocurrió un problema", "error");
          }
        },
        //=====================================================================================================================
        eliminarComprobantePago(id) {
          Swal.fire({
            title: "¿Eliminar comprobante?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
          }).then(result => {
            if (result.isConfirmed) {
              axios.post(this.ruta + "presupuestos/eliminarComprobantePagoVue", { id })
                .then(res => {
                  if (res.data === "COMPROBANTE ELIMINADO") {
                    Swal.fire("Eliminado", "El comprobante ha sido eliminado.", "success");
                    this.obtenerFacturas(); // Recargar tabla
                  } else {
                    Swal.fire("Error", res.data, "error");
                  }
                })
                .catch(() => {
                  Swal.fire("Error", "No se pudo eliminar el comprobante.", "error");
                });
            }
          });
        },
        //=====================================================================================================================
        subirComprobantePago(id, event) {
          const archivo = event.target.files[0];
          if (!archivo) return;

          const extension = archivo.name.split('.').pop().toLowerCase();
          const extensionesPermitidas = ['pdf', 'jpg', 'jpeg', 'bmp', 'tiff', 'webp'];
          const extensionesNoPermitidas = ['png', 'gif'];

          if (extensionesNoPermitidas.includes(extension) || !extensionesPermitidas.includes(extension)) {
            Swal.fire("¡No permitido!", "Solo se permiten PDF o imágenes (excepto PNG y GIF).", "error");
            return;
          }

          const formData = new FormData();
          formData.append("Archivo", archivo);
          formData.append("id", id);

          axios.post(this.ruta + 'presupuestos/subirComprobantePagoVue', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(response => {
            const respuesta = response.data;

            if (respuesta === "ARCHIVO GUARDADO") {
              Swal.fire("¡Guardado!", "El comprobante se guardó correctamente.", "success");
              this.obtenerFacturas(); // Recarga los datos si es necesario
            } else if (respuesta === "FORMATO NO VALIDO") {
              Swal.fire("¡Formato no válido!", "Este tipo de archivo no está permitido.", "error");
            } else if (respuesta === "PROBLEMAS AL PROCESAR EL ARCHIVO") {
              Swal.fire("¡Error!", "Ocurrió un problema al guardar el archivo.", "error");
            } else {
              Swal.fire("Error desconocido", respuesta, "warning");
            }
          }).catch(error => {
            console.error("Error al subir comprobante", error);
            Swal.fire("Error", "Hubo un problema al subir el comprobante.", "error");
          });
        },

        //=====================================================================================================================
        subirArchivo(id, event, tipo) {
          const fileInput = event.target;
          const archivo = fileInput.files[0];

          if (!archivo) return;

          const formData = new FormData();
          formData.append("Archivo", archivo);
          formData.append("id", id);
          formData.append("tipo", tipo);

          axios.post(this.ruta + 'presupuestos/GuardarArchivoALV', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(response => {
            const respuesta = response.data;

            if (respuesta === "ARCHIVO GUARDADO") {
              Swal.fire("¡Guardado!", "El documento se guardó correctamente.", "success");
              this.obtenerFacturas(); // Recargar datos si es necesario
            } else if (respuesta === "FORMATO NO VALIDO") {
              Swal.fire("¡No compatible!", "Este formato no es válido.", "error");
            } else if (respuesta === "PROBLEMAS AL PROCESAR EL ARCHIVO") {
              Swal.fire("¡Error!", "Ha ocurrido un problema al tratar de guardar el archivo.", "error");
            } else {
              Swal.fire("Mensaje inesperado Verificando información");
              this.obtenerFacturas(); // Recargar datos 
            }
          }).catch(error => {
            console.error("Error al subir archivo", error);
            Swal.fire("Error", "Hubo un problema al subir el archivo.", "error");
          });
        },
        //=====================================================================================================================
        archivoValido(nombre) {//Validación en los nombres de los archivos pdf y .mxl
          console.log('archivoValido: ' + nombre);
          return nombre && typeof nombre === 'string' && nombre.trim() !== '' && nombre !== 'null' && nombre !== 'undefined';
        },
        //=====================================================================================================================
        opcionesArchivo(id, tipo, usuario) {
          // 1. Determina el nombre de referencia (ref) del <select> en el template
          // Según si el archivo es PDF o XML
          const refName = tipo === 'pdf' ? `selectPDF${id}` : `selectXML${id}`;
          const namePDF = id + usuario;
          // 2. Obtiene el elemento <select> desde las referencias ($refs)
          // A veces Vue pone los refs como arrays, por eso se revisa si lo es
          // const selectElement = Array.isArray(this.$refs[refName])
          //   ? this.$refs[refName][0]
          //   : this.$refs[refName];
          let selectElement;
          if (Array.isArray(this.$refs[refName])) {
            selectElement = this.$refs[refName][0];
          } else {
            selectElement = this.$refs[refName];
          }
          // Si no encuentra el elemento <select>, salimos de la función
          if (!selectElement) return;

          // 3. Obtiene el texto y el valor de la opción seleccionada
          const selectedIndex = selectElement.selectedIndex;
          const selectedText = selectElement.options[selectedIndex].text;
          const selectedValue = selectElement.value;

          // 4. Si el usuario seleccionó "Descargar", se genera un enlace temporal para iniciar la descarga
          if (selectedText === "Descargar") {
            const a = document.createElement("a");
            a.href = selectedValue;     // Ruta del archivo
            a.download = "";            // Puedes ponerle un nombre si lo deseas
            document.body.appendChild(a);
            a.click();                  // Dispara la descarga
            document.body.removeChild(a); // Limpia el DOM
          } else {
            // 5. Si no es "Descargar", se asume que el usuario quiere eliminar el archivo
            const parametros = {
              id,
              file: selectedValue, // Ruta o identificador del archivo a eliminar
            };

            // 6. Se muestra una alerta de confirmación con SweetAlert
            Swal.fire({
              title: "¿Desea eliminarlo?",
              text: "El documento se borrará definitivamente.",
              icon: "warning",
              showCancelButton: true,
              cancelButtonColor: "#d33",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar",
            }).then((value) => {
              // 7. Si el usuario acepta eliminar el archivo
              if (value.isConfirmed) {
                $.ajax({
                  method: "POST",
                  url: URL_MODIFICA_ARCHIVO, // Esta URL se pasa desde el backend a la vista
                  data: parametros,
                  dataType: "html",
                  success: (datat) => {
                    try {
                      const respuesta = JSON.parse(datat);
                      if (respuesta.status) {
                        Swal.fire("¡Eliminado!", "El documento se borró correctamente.", "success");

                        // Vuelve a cargar la lista de facturas para reflejar el cambio
                        this.obtenerFacturas();
                      } else {
                        Swal.fire("¡Vaya!", "No se pudo eliminar. Intente de nuevo.", "error");
                      }
                    } catch (e) {
                      console.error("Respuesta no es JSON:", datat);
                      Swal.fire("¡Error!", "El servidor no devolvió una respuesta válida.", "error");
                    }
                  },
                  error: () => {
                    Swal.fire("¡No eliminado!", "Error al borrar el documento.", "error");
                  },
                });
              }
            });
          }
        },

        //=====================================================================================================================
        async verArchivos(id) {
          this.apiRutaBase = this.ruta + '/ArchivosPresupuesto/' + id;
            this.idActual = id;

          this.archivoNoEncontrado = false;
          this.contenidoXml = '';
          this.esXml = false;
          try {
            const respuesta = await axios.get(this.apiArchivosEncontrados + '/' + id);
            //this.mensaje = respuesta.data.repository;
            this.archivosEnCarpeta = respuesta.data.files;

            this.vistaPrevia = true;
            console.log(respuesta);
          } catch (error) {
            console.error('Error al obtener los datos:', error);
          }
        },
        //=====================================================================================================================
        // Este método se llama al hacer clic en un archivo
        mostrarArchivo(rutaArchivo) {
          const extension = rutaArchivo.split('.').pop().toLowerCase();

          if (extension === 'xml') {
            fetch(rutaArchivo)
              .then(res => res.text())
              .then(texto => {
                this.contenidoXml = texto;
                this.esXml = true;
                this.urlDelPdf = '';
              })
              .catch(() => {
                this.archivoNoEncontrado = true;
              });
          } else {
            this.urlDelPdf = rutaArchivo;
            this.esXml = false;
            this.contenidoXml = '';
          }
        },
        //=====================================================================================================================
        nuevaVentana($id) {
            const url = ruta + 'presupuestos/' + $id;
            // console.log(url);
            window.open(url, '_blank');
        },
        //=====================================================================================================================
        cerrarVistaPrevia(){
          this.vistaPrevia = false;
          this.urlDelPdf = '';
          this.contenidoXml = '';
          this.esXml = false;
        },
        //=====================================================================================================================
        iniciarBusqueda() {
          // const fechaInicial = document.getElementById('textFecInicial').value;
          // const fechaFinal = document.getElementById('textFecFinal').value;
          const hoy = new Date();//obtengo la fecha actual con todo y hora (Time)
          console.log(hoy);
          const fechaFinal = hoy.toISOString().split('T')[0];
          const ayer = new Date(hoy);
          ayer.setDate(hoy.getDate() - 1);
          const fechaInicial = ayer.toISOString().split('T')[0];
          // Si ya están definidas en el componente, respétalas, si no, usa las calculadas
          this.fechaInicial = this.fechaInicial || fechaInicial;
          this.fechaFinal = this.fechaFinal || fechaFinal;
          //|| operador || (doble barra) en JavaScript se llama operador lógico OR. Su función principal es devolver el primer valor "verdadero" (truthy) que encuentre, o el último valor si todos son falsos (falsy).
          if (!this.fechaInicial || !this.fechaFinal) {
            Swal.fire({
              title: 'Advertencia',
              text: 'Por favor selecciona ambas fechas.',
              icon: 'warning'
            });
            return;
          }

          FINAL_URL = `presupuestos/VistafacturasTodasVue/${this.fechaInicial}/${this.fechaFinal}`;
          console.log(FINAL_URL);
          this.apiFactura = ruta + FINAL_URL;
          this.obtenerFacturas();
        },
        //=====================================================================================================================
        vistaVisualizadas(){
          switch (this.View)
          {
            case 'listafacturasvalida'://vista listafacturasvalida.php
              console.log('Vista: ' + this.View);
              Object.assign(this.columnasVisibles, {
                validar: true,
                autorizado: false,
                pagado: false,
                editar: true,
                fecha_pago: false,
                Accion: false,
                tarjeta: true,
              });
              guardarEFG_BTN.addEventListener('click',function(){actualizarDatosFacturaEFG('actualizarTablaFactura')});
            break;
            case 'listafacturasTodas'://vista listafacturasTodas.php
              abrirCerrarEditarFactura();
              console.log('Vista: ' + this.View);
              Object.assign(this.columnasVisibles, {
                fecha_captura: true,
                Usuario: false,
                cuentaContable: false,
                personaDepartamento: false,
                Correo_Usuario: true,
                totalSuma: true,
                tarjeta: true,
              });
              Object.assign(this.botonesSegmentos, {
                  mostrarFechasServidor: true,
                  mostrarFechas: false,
                  totalSuma: true,
              });guardarEFG_BTN.addEventListener('click',function(){actualizarDatosFacturaEFG('actualizarTablaFactura')});
              this.iniciarBusqueda();
            break;
            case 'listafacturas':
              console.log('Vista: ' + this.View);
              Object.assign(this.columnasVisibles, {
                tarjeta: true,
              });
              abrirCerrarEditarFactura();
              eventListeners();
              calcularMontoDisponible();
              cargosManejoVista(true);
              traerFormasPagos('');document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')
              guardarEFG_BTN.addEventListener('click',function(){actualizarDatosFacturaEFG('actualizarTablaFactura')});
            break;
            case 'listafacturaspago'://debe estar Disponible unicamente en esta vista en especifico
              console.log('Vista: ' + this.View);
              Object.assign(this.columnasVisibles, {
                Usuario: false,
                Solicitado_por: true,
                Accion: true,
                editar: false,
                tarjeta: false,
                Agregar_PDF: false,
                Agregar_XML: false,
                Comprobante_pago: true,
              });
            
            break;
          }
        },
        //=====================================================================================================================
        obtenerFacturas() {
          //  const stack = new Error().stack;//era un prototipo para verificar desde donde se esta llamando la función para mostrar alertas dinamicas
          //
          //  console.log('Stack trace:\n', stack);
            if (this.apiFactura === this.ruta) {//esta función sirve para que si this.ruta esta vacio ya no realize la petició axios
                console.log('apiFactura esta Vació');
                return; // No hacer nada
            }

            // Mostrar alerta de carga
            Swal.fire({
                title: "Cargando datos...",
                text: "Por favor espera",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            // console.log('obtener facturas:   ' +  this.apiFactura);
            axios.get(this.apiFactura)
                .then(response => {
                    this.factura = response.data;

                    if (this.factura.length > 0) {
                        const keys = Object.keys(this.factura[0]);

                        this.columnasVisibles.Usuario = keys.includes("nombreUsuario");
                        this.columnasVisibles.cuentaContable = keys.includes("cuentaContable");
                        this.columnasVisibles.personaDepartamento = keys.includes("personaDepartamento");
                        this.columnasVisibles.nombreProveedor = keys.includes("nombreProveedor");
                        //this.columnasVisibles.tarjeta = keys.includes("numeroTarjeta");
                        this.columnasVisibles.tipo_factura = keys.includes("tipo_factura");
                    }

                    Swal.close(); // Ocultar alerta
                })
                .catch(error => {
                    console.log(error);
                    Swal.fire({
                        title: "Error",
                        text: "No se pudieron obtener los datos",
                        icon: "error"
                    });
                });
        },
        //=====================================================================================================================
        limpiarFechas() {
          this.fechaInicial = '';
          this.fechaFinal = '';
        },
        //=====================================================================================================================
        seleccionarSugerencia(sugerencia) {
          this.buscar = sugerencia;
          this.sugerencias = [];
        }
        //=====================================================================================================================
      },
      computed: {
        //=====================================================================================================================
        filtroFactura() {
          const busqueda = this.buscar.toLowerCase().trim();

          return this.factura.filter(row => {
            const cumpleBusqueda = Object.values(row).some(valor =>
              String(valor).toLowerCase().includes(busqueda)
            );
            // Si hay fechas aplicadas, también filtra por rango
            let cumpleFechas = true;
            if (this.fechaInicial && this.fechaFinal) {
              const fecha = new Date(row.fecha_factura);
              const inicio = new Date(this.fechaInicial);
              const fin = new Date(this.fechaFinal);
              cumpleFechas = fecha >= inicio && fecha <= fin;
            }
             return cumpleBusqueda && cumpleFechas;
          });
        },
        //=====================================================================================================================
        totalSinIVA() {
            let total = 0;

            this.filtroFactura.forEach(factura => {
              // Convierte el valor a número y suma, o suma 0 si no hay valor
              const monto = Number(factura.totalfactura) || 0;
              total += monto;
            });

            return total;
          },
        //=====================================================================================================================
        totalConIVA() {
          let total = 0;

          this.filtroFactura.forEach(factura => {
            // Convierte el valor a número y suma, o suma 0 si no hay valor
            const montoConIVA = Number(factura.totalconiva) || 0;
            total += montoConIVA;
          });

          return total;
        },
        //=====================================================================================================================
      },
    });const vm = app.mount("#app");
    window.vm = vm; 
     //----------------------------------------------------------------------TERMINA COMPONENTE VUE---------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {//Roberto Alvarez 09-junio-2025
      // Solo ejecutar si estás en la vista correcta
      if (typeof View !== 'undefined' && View === 'listafacturaspago') {
        const form = document.getElementById('grabarFechaForm');

        if (form) {
          form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evita que se recargue la página

            const IDFact = document.getElementById('IDFact').value;
            const IDUser = document.getElementById('IDUser').value;
            const fechaNacimiento = document.getElementById('fechaNacimiento').value;
            const comprobante = document.getElementById('Comprobante_pago').innerText.trim();

            // ⚠️ Validación de comprobante vacío/nulo/indefinido
            if (!comprobante) {
              Swal.fire('Error', '⚠️ El comprobante de pago está vacío.', 'error');
              return; // Salir sin enviar
            }

            const url = form.getAttribute('action');

            axios.get(url, {
              params: {
                IDFact: IDFact,
                IDUser: IDUser,
                unofNacimiento: fechaNacimiento
              },
              responseType: 'json'
            })
            .then(function(response) {
              console.log('Respuesta:', response.data);
              Swal.fire('¡Éxito!', response.data.message, 'success');
              // window.vm.obtenerFacturas(); // Si deseas refrescar
            })
            .catch(function(error) {
              console.error('Error al enviar:', error);
              Swal.fire('Error', 'Hubo un problema al guardar la fecha.', 'error');
            });
          });
        } else {
          console.warn('⚠️ No se encontró grabarFechaForm en esta vista.');
        }
      }

    });





   
//  function exportarConXLSX() {
//     const tabla = document.getElementById('Mitabla');
//     const tablaClon = tabla.cloneNode(true);

//     const encabezadosNoExportar = [
//       'AccionesTabla',
//       'Validar',
//       'Agregar PDF',
//       'Agregar XML',
//       'Archivos'
//     ];

//     // Obtener índice de columnas a eliminar del thead
//     const ths = tablaClon.tHead.rows[0].cells;
//     const indicesAEliminar = [];

//     for (let i = 0; i < ths.length; i++) {
//       const texto = ths[i].innerText.trim();
//       if (encabezadosNoExportar.includes(texto)) {
//         indicesAEliminar.push(i);
//       }
//     }

//     // Eliminar columnas del thead
//     for (let i = 0; i < tablaClon.tHead.rows.length; i++) {
//       indicesAEliminar.slice().reverse().forEach(idx => {
//         if (tablaClon.tHead.rows[i].cells[idx]) {
//           tablaClon.tHead.rows[i].deleteCell(idx);
//         }
//       });
//     }

//     // Eliminar columnas del tbody
//     const filasBody = tablaClon.tBodies[0].rows;
//     for (let i = 0; i < filasBody.length; i++) {
//       indicesAEliminar.slice().reverse().forEach(idx => {
//         if (filasBody[i].cells[idx]) {
//           filasBody[i].deleteCell(idx);
//         }
//       });
//     }

//     // Convertir a Excel
//     const wb = XLSX.utils.table_to_book(tablaClon, {sheet: "Facturas"});
//     XLSX.writeFile(wb, 'Facturas.xlsx');
//   }
    //=====================================================================================================================
    async function exportarConXLSX() {
      const tabla = document.getElementById('Mitabla'); // Obtiene la tabla HTML con id "Mitabla"
      const encabezadosNoExportar = ['AccionesTabla', 'Validar', 'Agregar PDF', 'Agregar XML', 'Archivos','Accion']; // Lista de encabezados que no se deben exportar

      const workbook = new ExcelJS.Workbook(); // Crea un nuevo libro de trabajo Excel
      const worksheet = workbook.addWorksheet("Facturas"); // Crea una nueva hoja llamada "Facturas"

      const filaEncabezados = []; // Almacena los encabezados que sí se van a exportar
      const columnasAExcluir = []; // Guarda los índices de las columnas que se van a excluir

      // Procesar encabezados (thead)
      const ths = tabla.querySelectorAll("thead tr th"); // Selecciona todos los encabezados (th) de la tabla

      ths.forEach((th, index) => { // Recorre cada encabezado
        const nombreColumna = th.getAttribute('name') || th.innerText.trim(); // Usa atributo 'name' o texto visible
        if (encabezadosNoExportar.includes(nombreColumna)) { // Si está en la lista de exclusión
          columnasAExcluir.push(index); // Guarda el índice
        } else {
          filaEncabezados.push({
            header: nombreColumna,        // Encabezado visible
            key: `col${index}`,           // Clave única
            width: th.offsetWidth / 7    // Ancho aproximado, mientras mas chico el numero mas ancha es la celda del excel 
          });
        }
      });
      worksheet.columns = filaEncabezados; // Define las columnas del archivo Excel con los encabezados válidos

      // Procesar filas (tbody)
      const filas = tabla.querySelectorAll("tbody tr"); // Selecciona todas las filas del cuerpo de la tabla
      filas.forEach((filaDOM) => { // Recorre cada fila
        const filaExcel = []; // Arreglo que almacenará los valores de una fila para Excel
        const celdas = filaDOM.querySelectorAll("td"); // Selecciona todas las celdas de la fila

        celdas.forEach((celda, index) => { // Recorre cada celda
          if (!columnasAExcluir.includes(index)) { // Solo si la columna no está excluida
            filaExcel.push(celda.innerText.trim()); // Guarda el texto de la celda
          }
        });

        const nuevaFila = worksheet.addRow(filaExcel); // Agrega la fila a la hoja de Excel

        // Aplicar estilos desde el DOM
        celdas.forEach((celda, index) => {
          if (!columnasAExcluir.includes(index)) {
            const computedStyle = window.getComputedStyle(celda); // Obtiene los estilos calculados de la celda
            const cell = nuevaFila.getCell(filaExcel.indexOf(celda.innerText.trim()) + 1); // Obtiene la celda correspondiente en Excel

            // Fondo
            const bgColor = computedStyle.backgroundColor; // Obtiene el color de fondo
            if (bgColor && bgColor !== "rgba(0, 0, 0, 0)") { // Si el color no es transparente
              const rgb = bgColor.match(/\d+/g); // Extrae valores RGB
              const hex = rgb ? rgb.slice(0, 3).map(x => parseInt(x).toString(16).padStart(2, '0')).join('') : "FFFFFF"; // Convierte a formato hexadecimal
              cell.fill = { // Aplica color de fondo a la celda de Excel
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: hex.toUpperCase() }
              };
            }

            // Fuente
            cell.font = {
              name: 'Arial', // Fuente utilizada
              size: 8, // Tamaño de fuente
              bold: computedStyle.fontWeight === '700' // Aplica negrita si el estilo lo tiene
            };

            // Alineación
            cell.alignment = {
              vertical: 'middle', // Alineación vertical centrada
              horizontal: computedStyle.textAlign === 'center' ? 'center' : 'left', // Alineación horizontal según el estilo
              wrapText: true // Habilita el ajuste de texto
            };

            // Bordes
            cell.border = {
              top: { style: 'thin' },
              left: { style: 'thin' },
              bottom: { style: 'thin' },
              right: { style: 'thin' }
            };
          }
        });

        // Altura automática (deja que Excel determine la altura adecuada)
        nuevaFila.height = undefined;
      });

      // Descargar archivo
      const buffer = await workbook.xlsx.writeBuffer(); // Convierte el libro a un buffer binario
      const blob = new Blob([buffer], {
        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      }); // Crea un archivo tipo Blob (Excel)

      const link = document.createElement("a"); // Crea un enlace temporal
      link.href = URL.createObjectURL(blob); // Crea una URL para el Blob
      link.download = "Facturas.xlsx"; // Nombre del archivo que se descargará
      link.click(); // Dispara la descarga
    }
    //=====================================================================================================================
  function eventListeners(){
    document.querySelector('.btnGrabaproveedor').addEventListener('click',actualizaProveedores);
    document.querySelector('.agregasto').addEventListener('click',llamagastoEspecial);
    document.querySelector('.grabaGastos a').addEventListener('click',enviaCargos);
  }
  //=====================================================================================================================
  function enviaCargos(e)
  {
    e.preventDefault();
    let gastoCCC= document.querySelector("#gastosCcc").value;
    let gastoCCo=document.querySelector("#gastosCco").value;
    let gastoCCInst=document.querySelector("#gastosInst").value;
    let gastoEstrategia=document.querySelector("#gastosEstrategia").value;
    
      $('#ccc').val(gastoCCC);
      $('#cco').val(gastoCCo);
      $('#inversion').val(gastoCCInst);
      $('#estrategia').val(gastoEstrategia);
    if(gastoCCC==""){gastoCCC=0.0;}
    if(gastoCCo==""){gastoCCC=0.0;}
    if(gastoCCInst==""){gastoCCC=0.0;}
    if(gastoEstrategia==""){gastoEstrategia=0.0;}

    $(".modalGastos").fadeOut();
    let total = parseFloat(gastoCCC)+ parseFloat(gastoCCo) + parseFloat(gastoCCInst)+parseFloat(gastoEstrategia);
    $('#CargoGes').val(total);
    Suma();

  }
  //=====================================================================================================================
  function llamagastoEspecial(e)
  {
    //console.log(e.target);
    if(e.target.classList.value=='fas fa-plus-circle')
    {
      //console.log('hiciste clic');
      $(".modalGastos").fadeIn();
    }
  }
  //=====================================================================================================================
  // function abrirModalFecha(objeto)
  // {
  //     document.getElementById('divModalGenerico').classList.toggle('modalCierra');
  //     document.getElementById('divModalGenerico').classList.toggle('modalAbre');
  //     let row=objeto.parentNode.parentNode;
  //     document.getElementById('usuarioFacturaID').innerHTML=row.dataset.id;
  //     document.getElementById('usuarioFacturaFolio').innerHTML=row.dataset.usuario;
  //     document.getElementById('IDFact').value=row.dataset.id;
  //     document.getElementById('IDUser').value=row.dataset.usuario;
  //     document.getElementById('usuarioFacturaEmail').innerHTML=row.dataset.folio;
  //     document.getElementById('grabarFechaForm').setAttribute('action',objeto.dataset.href)
  // }
  
    // document.getElementById('usuarioFacturaID').innerHTML = row.dataset.id;
    // document.getElementById('usuarioFacturaFolio').innerHTML = row.dataset.usuario;
    // document.getElementById('IDFact').value = row.dataset.id;
    // document.getElementById('IDUser').value = row.dataset.usuario;
    // document.getElementById('usuarioFacturaEmail').innerHTML = row.dataset.folio;
    // document.getElementById('grabarFechaForm').setAttribute('action', objeto.dataset.href);
  // function abrirModalFecha(objeto) {
  //   const row = objeto.closest("tr"); // Más robusto que parentNode.parentNode

  //   document.getElementById('divModalGenerico').classList.toggle('modalCierra');
  //   document.getElementById('divModalGenerico').classList.toggle('modalAbre');

    
  //     window.vm.obtenerFacturas(); // ✅ Llama al método del componente Vue
  // }
  function abrirModalFecha(objeto) {//Modificado-Roberto-Alvarez-[10-Junio-2025]
  const row = objeto.closest("tr");

  const modal = document.getElementById('divModalGenerico');
  const estabaAbierto = modal.classList.contains('modalAbre');

  modal.classList.toggle('modalCierra');
  modal.classList.toggle('modalAbre');
   if (estabaAbierto) {
      window.vm.obtenerFacturas(); // ✅ Solo cuando el modal se cierra
    }
    document.getElementById('usuarioFacturaID').innerHTML = row.dataset.id;
    document.getElementById('usuarioFacturaFolio').innerHTML = row.dataset.usuario;
    document.getElementById('IDFact').value = row.dataset.id;
    document.getElementById('IDUser').value = row.dataset.usuario;
    document.getElementById('Comprobante_pago').innerHTML = row.dataset.comprobantePago;
    document.getElementById('usuarioFacturaEmail').innerHTML = row.dataset.folio;
    document.getElementById('grabarFechaForm').setAttribute('action', objeto.dataset.href);

    // Si estaba abierto y ahora se cierra, entonces actualiza Vue
   
  }

  
  //=====================================================================================================================
  function actualizaProveedores(e)
  {
    e.preventDefault();
    //console.log(e);
  let nombreprovedor = $("#mproveedor").val();
  let dias =      $("#mdias").val(); 
  let clave =      $("#mclave").val(); 
  let cuenta =       $("#mcuenta").val();
  let banco =     $("#mbanco").val();
  let direccion =      $("#mdireccion").val(); 
  let correo =      $("#mcorreo").val();
  let celular =      $("#mcelular").val();
  let contacto =     $("#mcontacto").val();
  let telefono =     $("#mtelefono").val();
  let extencion =     $("#mextencion").val();
  let giro =      $("#mgiro").val();
  let id =      $("#idprovee").val();
  //console.log(nombreprovedor);
  if(nombreprovedor =="")
  {
    document.getElementById('mproveedor').focus();
    Swal.fire(
          'Giro!',
          'El giro del Cliente Esta Vacio',
          'warning'
        );   
  }
  if(contacto == "")
  {
  document.getElementById('mcontacto').focus();
        Swal.fire(
          'Contacto!',
          'El Contacto Esta Vacio',
          'warning'
        );   
  return false;
  }
  //telefono
  if(telefono == "")
  {
  document.getElementById('mtelefono').focus();
        Swal.fire(
          'Telefono!',
          'El Telefono Esta Vacio',
          'warning'
        );   
  return false;
  }
  //Extencion
  if(extencion == "")
  {
  document.getElementById('mextencion').focus();
        Swal.fire(
          'Extencion!',
          'La Extencion Esta Vacio',
          'warning'
        );   
  return false;
  }
  //celular
  if(celular == "")
  {
  document.getElementById('mcelular').focus();
        Swal.fire(
          'Celular!',
          'El celular Esta Vacio',
          'warning'
        );   
  return false;
  }
  //email""
  if(correo == "")
  {
  document.getElementById('mcorreo').focus();
        Swal.fire(
          'email!',
          'El email Esta Vacio',
          'warning'
        );   
  return false;
  }
    //direccion
    if(direccion == "")
  {
  document.getElementById('mdireccion').focus();
        Swal.fire(
          'direccion!',
          'La direccion Esta Vacio',
          'warning'
        );   
  return false;
  }
    //banco
    if(banco == "")
  {
  document.getElementById('mbanco').focus();
        Swal.fire(
          'banco!',
          'El Banco Esta Vacio',
          'warning'
        );   
  return false;
  }
  //cuenta
  if(cuenta == "")
  {
  document.getElementById('mcuenta').focus();
        Swal.fire(
          'cuenta!',
          'La Cuenta Esta Vacio',
          'warning'
        );   
  return false;
  } 
  //clave 
  if(clave == "")
  {
  document.getElementById('mclave').focus();
        Swal.fire(
          'clave!',
          'La clave Esta Vacio',
          'warning'
        );   
  return false;
  }
  //dias 
  if(dias == "")
  {
  document.getElementById('mdias').focus();
        Swal.fire(
          'dias de Credito!',
          'El dia de credito Esta Vacio',
          'warning'
        );   
  return false;
  }


  if(giro == "")
  {
  //document.getElementById('mgiro').focus();
        Swal.fire(
          'Giro!',
          'El Nombre del giro esta Vacio',
          'warning'
        );   
  return false;
  }
  //Actualizamos Proveedores
  xhr = new XMLHttpRequest();
  datos = new FormData();
  datos.append('nombreprovedor',nombreprovedor);
  datos.append('dias',dias);
  datos.append('clave',clave);
  datos.append('cuenta',cuenta);
  datos.append('banco',banco);
  datos.append('direccion',direccion);
  datos.append('correo',correo);
  datos.append('celular',celular);
  datos.append('contacto',contacto);
  datos.append('telefono',telefono);
  datos.append('extencion',extencion);
  datos.append('giro',giro);
  datos.append('id',id);
  xhr.open('POST',"<?php echo base_url();?>presupuestos/actualizadatosProveedor",true);
  xhr.onload=function()
  {
    if(this.status ===200)
    {
      var respuesta = JSON.parse(xhr.responseText);
      console.log(respuesta);
    }
  }
  xhr.send(datos);
  Swal.fire(
          'Actualizado!',
          'El Proveedor ha sido Actualizado',
          'success'
        )
        cierraModalfecha();
  //Termina Actualizacion
  }
  //=====================================================================================================================
  /************************************** */
  function quitarListaParaFacturar(objeto)
  {
    let row=objeto.parentNode.parentNode;
    let index=row.rowIndex;
    let fianzas=row.getAttribute('data-fianzas');
    let seguros=row.getAttribute('data-seguros');
    let coorporativo=row.getAttribute('data-coorporativo');
    let especial=row.getAttribute('data-especial');
    let monto=row.getAttribute('data-monto');
    document.getElementById('CargoFianzas').value=parseFloat(document.getElementById('CargoFianzas').value)-parseFloat(fianzas);
    document.getElementById('CargoInst').value=parseFloat(document.getElementById('CargoInst').value)-parseFloat(seguros);
    document.getElementById('Corporativos').value=parseFloat(document.getElementById('Corporativos').value)-parseFloat(coorporativo);

  document.getElementById('CargoGes').value=parseFloat(document.getElementById('CargoGes').value)-parseFloat(especial);

  document.getElementById('CargoTotal').value=parseFloat(document.getElementById('CargoTotal').value)-parseFloat(monto);

    document.getElementById('tableConNotasParaFacturar').deleteRow(index);
    
  }
  //=====================================================================================================================
  function llevarNotasParaFacturar()
  {
    document.getElementById('divContieneNotasParaFacturar').innerHTML='';
    let facturar=document.getElementsByName('checkParaFacturar');
    let cant=facturar.length;

    let rowTabla='<table class="table" id="tableConNotasParaFacturar">';
    let fianzasTotal=0;
    let segurosTotal=0;
    let coorporativoTotal=0;
    let especialTotal=0;
    let montoTotal=0;
    for(let i=0;i<cant;i++)
    {
      if(facturar[i].checked)
      {
        let fianzas=facturar[i].parentNode.parentNode.getAttribute('data-fianzas');
        let seguros=facturar[i].parentNode.parentNode.getAttribute('data-seguros');
        let coorporativo=facturar[i].parentNode.parentNode.getAttribute('data-coorporativo');
        let especial=facturar[i].parentNode.parentNode.getAttribute('data-especial');
        let monto=facturar[i].parentNode.parentNode.getAttribute('data-monto');
        let id=facturar[i].parentNode.parentNode.getAttribute('data-idnotascompra');
        rowTabla=rowTabla+'<tr data-fianzas="'+fianzas+'" data-seguros="'+seguros+'" data-coorporativo="'+coorporativo+'" data-especial="'+especial+'" data-monto="'+monto+'" data-idnotascompra="'+id+'">'+facturar[i].parentNode.parentNode.innerHTML+'</tr>';
        fianzasTotal=parseFloat(fianzasTotal)+parseFloat(fianzas);
        segurosTotal=parseFloat(segurosTotal)+parseFloat(seguros);
        coorporativoTotal=parseFloat(coorporativoTotal)+parseFloat(coorporativo);
        especialTotal=parseFloat(especialTotal)+parseFloat(especial);
        montoTotal=parseFloat(montoTotal)+parseFloat(monto);
      }
    }
    rowTabla=rowTabla+'</table>';  
    document.getElementById('divContieneNotasParaFacturar').innerHTML=rowTabla;  
    document.getElementById('CargoFianzas').value=fianzasTotal;
    document.getElementById('CargoInst').value=segurosTotal;
    document.getElementById('Corporativos').value=coorporativoTotal;
    document.getElementById('CargoGes').value=especialTotal;
    document.getElementById('CargoTotal').value=montoTotal;
    console.log(document.getElementById('tableConNotasParaFacturar').rows[0].cells[9].innerHTML);
    let cantNotas=document.getElementById('tableConNotasParaFacturar').rows.length;
    for(let i=0;i<cantNotas;i++)
    {
      document.getElementById('tableConNotasParaFacturar').rows[i].cells[9].innerHTML='<button class="btn btn-danger" onclick="quitarListaParaFacturar(this)">X</button>';
    }
    cerrarModal('divModalParaFacturar');
  }
  //=====================================================================================================================
  function traerNotasDePersonas(datos)
  {
    if(datos=='')
    {
      let params='';
      {
        let facturar=document.getElementsByName('checkParaFacturar');
        let cant=facturar.length;
      }
    params=params+'idPersona='+document.getElementById('selectPersonasConNotas').value;
    controlador="contabilidad/traerNotasDePersonas/?";
    peticionAJAX(controlador,params,'traerNotasDePersonas');   

    }
    else
    {
      pintarTablaNotas(datos.notas,'tbodyNotasPersona',1);
      console.log(datos)
    }
  }
  //=====================================================================================================================
  function buscarPersonasConNotas(datos)
  {
    if(datos=="")
    {
      let params='';
    controlador="contabilidad/buscarPersonasConNotas/";
    document.getElementById('tbodyNotasPersona').innerHTML='';
      peticionAJAX(controlador,params,'buscarPersonasConNotas');   
      cerrarModal('divModalParaFacturar');
      
    }
    else{dibujaSelectPersonasConNotas(datos.personasConNotas); }
  }
  //=====================================================================================================================
  function dibujaSelectPersonasConNotas(datos)
  {
    let option='';
    let cant=datos.length;
    for(let i=0;i<cant;i++)
    {
      option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].apellidoPaterno+' '+datos[i].apellidoMaterno+' '+datos[i].nombres+'</option>';
    }
    document.getElementById('selectPersonasConNotas').innerHTML=option;
  }
  //=====================================================================================================================
  function borrarNotas(datos,idNota=null)
  {
    if(datos=='')
    {
      let params='';
    params=params+'idNotasCompra='+idNota;
    controlador="contabilidad/borrarNotas/?";
    peticionAJAX(controlador,params,'borrarNotas');   

    }
    else
    {
      alert(datos.mensaje);
      pintarTablaNotas(datos.notas,'tbodyNotas',0);
    }
  }
  //=====================================================================================================================  
  function guardarNota(datos)
  {
    if(datos=='')
    {
      let params='';
      params=params+'idFormaPago='+document.getElementById('selectFormasPago').value;
      params=params+'&notasDescripcion='+document.getElementById('notasDescripcio').value;
      params=params+'&notasCargoFianzas='+document.getElementById('notasCargoFianzas').value;
      params=params+'&notasCargoEspeciales='+document.getElementById('notasCargoEspeciales').value;
      params=params+'&notasTotal='+document.getElementById('notasTotal').value;
      params=params+'&notasCargoCoorporativos='+document.getElementById('notasCargoCoorporativos').value;
      params=params+'&fechaNota='+document.getElementById('fechaNota').value;
      params=params+'&notasCargoSeguros='+document.getElementById('notasCargoSeguros').value;
      controlador="contabilidad/guardarNota/?";
      peticionAJAX(controlador,params,'guardarNota');   
    }
    else
    {
      alert(datos.mensaje);
      pintarTablaNotas(datos.notas,'tbodyNotas',0); 
      inicializaNotas();
    }
  }  
  //=====================================================================================================================
  function pintarTablaNotas(notas,tabla,paraFacturar=null)
  {
    let cant=notas.length;
    let row='';
    let cargoFianzas=0;
    let cargoSeguros=0;
    let cargoCoorporativo=0;
    let cargoEspecial=0;
    let monto=0;
    for(let i=0;i<cant;i++)
    {
      cargoFianzas=parseFloat(cargoFianzas)+parseFloat(notas[i].cargoFianzas);
      cargoSeguros=parseFloat(cargoSeguros)+parseFloat(notas[i].cargoSeguros);
      cargoCoorporativo=parseFloat(cargoCoorporativo)+parseFloat(notas[i].cargoCoorporativo);
      cargoEspecial=parseFloat(cargoEspecial)+parseFloat(notas[i].cargoEspecial);
      monto=parseFloat(monto)+parseFloat(notas[i].montoCompra);
      row=row+'<tr data-fianzas="'+notas[i].cargoFianzas+'" data-seguros="'+notas[i].cargoSeguros+'" data-coorporativo="'+notas[i].cargoCoorporativo+'" data-especial="'+notas[i].cargoEspecial+'" data-monto="'+notas[i].montoCompra+'" data-idnotascompra="'+notas[i].idNotasCompra+'">';
      row=row+'<td>'+notas[i].formaPago+'</td>';
      row=row+'<td>'+notas[i].numeroTarjeta+'</td>';
      row=row+'<td>'+notas[i].descripcionCompras+'</td>';
      row=row+'<td>'+notas[i].soloFecha+'</td>';  
      row=row+'<td>'+notas[i].cargoFianzas+'</td>';
      row=row+'<td>'+notas[i].cargoSeguros+'</td>';
      row=row+'<td>'+notas[i].cargoCoorporativo+'</td>';
      row=row+'<td>'+notas[i].cargoEspecial+'</td>';
      row=row+'<td>'+notas[i].montoCompra+'</td>';
      if(paraFacturar==1){row=row+'<td><input type="checkbox" value="'+notas[i].idNotasCompra+'" name="checkParaFacturar" checked></td>';}    
      else{row=row+'<td><button onclick="borrarNotas(\'\','+notas[i].idNotasCompra+')" class="btn btn-danger">X</button></td>';}
      row=row+'</tr>'

    }
    row=row+'<tr>';
    row=row+'<td>Totales</td>';
    row=row+'<td></td>';
    row=row+'<td></td>';
    row=row+'<td></td>';  
    row=row+'<td>'+cargoFianzas+'</td>';
    row=row+'<td>'+cargoSeguros+'</td>';
    row=row+'<td>'+cargoCoorporativo+'</td>';
    row=row+'<td>'+cargoEspecial+'</td>';
    row=row+'<td>'+monto+'</td>';
    row=row+'<td></td>';
    row=row+'</tr>'
    document.getElementById(tabla).innerHTML=row;
  }
  //=====================================================================================================================
  function cambiarFormPago(objeto)
  {
    let index=objeto.selectedIndex;
    let especial=objeto.options[index].getAttribute('data-especial');
    if(especial==0)
    {
      document.getElementById('notasCargoFianzas').removeAttribute('disabled');
      document.getElementById('notasCargoSeguros').removeAttribute('disabled');
      document.getElementById('notasCargoCoorporativos').removeAttribute('disabled');
      document.getElementById('notasCargoEspeciales').setAttribute('disabled','true');
    }
    else
    {
      document.getElementById('notasCargoFianzas').setAttribute('disabled','true');
      document.getElementById('notasCargoSeguros').setAttribute('disabled','true');
      document.getElementById('notasCargoCoorporativos').setAttribute('disabled','true');
      document.getElementById('notasCargoEspeciales').removeAttribute('disabled');
    }
    inicializaNotas();
  }
  //=====================================================================================================================
  function traerFormasPagos(datos)
  {
    if(datos=='')
    {
      let params='';
    //params=params+'comentario='+document.getElementById('comentarioParaAN').value;   
    controlador="contabilidad/traerFormasPagos/?";
      peticionAJAX(controlador,params,'traerFormasPagos');   
      //cerrarModal('divModalGenerico');
    }
    else
    {
    
    let cant=datos.tarjetas.length;
    let option='<option value="0">TARJETAS ASIGNADAS</option>';
    for(let i=0;i<cant;i++)
    {
      if(datos.tarjetas[i].esTarjetaEspecial==1)
      {
      option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'</option>';
      }
      else{

        option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')</option>';}
    }
      document.getElementById('selectTarjetasCredito').innerHTML=option;
    }
  }
  //=====================================================================================================================
  function inicializaNotas()
  {
      document.getElementById('notasCargoFianzas').value=0;
    document.getElementById('notasCargoEspeciales').value=0;
    document.getElementById('notasTotal').value=0;
    document.getElementById('notasCargoSeguros').value=0;
    document.getElementById('notasCargoCoorporativos').value=0;
  }
  //=====================================================================================================================
  function peticionAJAX(controlador,parametros,funcion){
    var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
    var url=direccionAJAX+controlador;
    req.open('POST', url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function (aEvt) 
    {
      if (req.readyState == 4) {
        if(req.status == 200)
          {           
          var respuesta=JSON.parse(this.responseText); 
          window[funcion](respuesta);                                                          
        }     
    }
    };
    req.send(parametros);
  }
  //=====================================================================================================================
  function cerrarModal(modal)
  {
      document.getElementById(modal).classList.toggle('modalCierra');
      document.getElementById(modal).classList.toggle('modalAbre');   
  }
  //=====================================================================================================================
  function cierraModalfecha()
  {
    $(".modalProveedoor").fadeOut();
    window.vm.obtenerFacturas(); // ✅ Llama al método del componente Vue
  }
  //=====================================================================================================================
  function cierraModalgasto()
  {
    $(".modalGastos").fadeOut();
  }
  //=====================================================================================================================
 function eliminarFacturaSRP(event, datos = '') {//EDIT.ROBERTO-ALVAREZ
    event.preventDefault(); // Evita el envío tradicional
    if (datos == '') {
      const filaSeleccionada = document.getElementsByClassName('rowSeleccionado')[0];
      if (filaSeleccionada) {
        const fila = filaSeleccionada.dataset.idfactura;
        Swal.fire({
          title: "¿Desea borrarlo?",
          text: "Los datos de " + fila + " se eliminarán. ",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
        }).then((result) => {
        if (result.isConfirmed) {
          const params = "id=" + fila;
          const controlador = "presupuestos/eliminarFactura/?";
          peticionAJAX(controlador, params, 'eliminarFactura');
          obtenerFacVue();
          Swal.fire("¡Eliminado!", "La fila se borró correctamente", "success");  
        } else {
          Swal.fire("¡Cancelado!", "No se eliminó ningún campo.", "error");
        }
        });
      } else {
        Swal.fire({
          title: "¡Por favor!",
          text: "Seleccione factura para eliminar.  eliminarFactura",
          icon: "warning",
          confirmButtonText: "OK"
        });
      }
    } else {
      if (!datos.status) {
        alert(datos.mensaje);
      } else {
        Swal.fire("¡Cancelado!", "No se elimino ningun campo.", "success");
      }
    }
  }
  //=====================================================================================================================
 
  //Segunda parte de script
    if (typeof respuesta !== "undefined" && respuesta !== "") {//Modificado-Roberto-Angel cetzal Alvarez-2025-05-26
      if (respuesta === "ARCHIVO GUARDADO") {
          swal("¡Guardado!", "El documento se guardó correctamente.", "success");
      } else if (respuesta === "FORMATO NO VALIDO") {
          swal("¡No compatible!", "Este formato no es válido.", "error");
      } else if (respuesta === "PROBLEMAS AL PROCESAR EL ARCHIVO") {
          swal("¡Error!", "Ha ocurrido un problema al tratar de guardar el archivo.", "error");
      } else {
          alert(respuesta);
      }
    }
    //===================================================================================================================== 
    //alert(window.location.href );

    //Selección para descargar o eliminar PDF o XML cuando se elimina el archivo
    // function opcionesArchivo(objeto) {// Modificado [Suemy][2024-10-17]Modificado--Roberto-Alvarez-2025-06-05 
    //   // Obtenemos el contenedor padre del objeto (generalmente un botón o select)
    //   var contenedor = objeto.parentNode;
    //   console.log('contenedor'+contenedor);

    //   // Recorremos todos los elementos hijos del contenedor
    //   for (let i = 0; i < contenedor.childNodes.length; i++) {
    //     const hijo = contenedor.childNodes[i];

    //     // Si el hijo es un SELECT (desplegable con opciones)
    //     if (hijo.nodeName === "SELECT") {
    //       const opcionSeleccionada = hijo.options[hijo.selectedIndex].text;

    //       // Si la opción seleccionada es "Descargar", iniciamos descarga del archivo
    //       if (opcionSeleccionada === "Descargar") {
    //         const url = hijo.value;
    //         const enlaceDescarga = document.createElement("a");
    //         enlaceDescarga.href = url;
    //         enlaceDescarga.download = ""; // Puedes poner aquí el nombre del archivo, como "archivo.pdf"
    //         document.body.appendChild(enlaceDescarga);
    //         enlaceDescarga.click(); // Dispara la descarga
    //         document.body.removeChild(enlaceDescarga);
    //       } else {
    //         // Si no es "Descargar", entonces se asume que se quiere ELIMINAR el archivo
    //         let parametros = {
    //           "id": $(objeto).data("id"),
    //           "file": hijo.value
    //         };

    //         // Dirección donde se envía la petición para eliminar el archivo
    //         var urlEliminacion = "<?php echo(base_url().'presupuestos/modificaArchivo/')?>";

    //         // Mostrar cuadro de confirmación
    //         Swal.fire({
    //           title: "¿Desea eliminarlo?",
    //           text: "El documento se borrará definitivamente.",
    //           icon: "warning",
    //           showCancelButton: true,
    //           cancelButtonColor: '#d33',
    //           confirmButtonText: 'Aceptar',
    //           cancelButtonText: 'Cancelar'
    //         }).then((resultado) => {
    //           if (resultado.isConfirmed) {
    //             // Si el usuario confirma, se realiza la petición AJAX para eliminar el archivo
    //             $.ajax({
    //               method: "POST",
    //               data: parametros,
    //               url: urlEliminacion,
    //               dataType: "html",
    //               success: function(respuesta) {
    //                 var resultado = JSON.parse(respuesta);
    //                 console.log(resultado);

    //                 if (resultado.status) {
    //                   // Si la eliminación fue exitosa
    //                   Swal.fire("¡Eliminado!", "El documento se borró correctamente.", "success");

    //                   const tipoArchivo = resultado.tipo.toUpperCase();
    //                   const idArchivo = resultado.id;

    //                   // Se construye un nuevo input para subir archivo (PDF o XML)
    //                   var etiqueta = (resultado.tipo === "pdf") ?
    //                     '<label class="subir-pdf" for="file">Agregar PDF</label>' :
    //                     '<label class="subir-xml" for="file">Agregar XML</label>';

    //                   var htmlNuevoInput = `
    //                     <div class="container-spinner" id="Spinner${tipoArchivo}${idArchivo}"></div>
    //                     <div class="divContenedor">
    //                       <form action="<?=base_url()?>presupuestos/GuardarArchivo" 
    //                             id="GuardarArchivo${idArchivo}" 
    //                             enctype="multipart/form-data" 
    //                             method="post">
    //                         <input type="hidden" value="${idArchivo}" name="id">
    //                         <input type="hidden" value="${resultado.tipo}" name="tipo">
    //                         <input type="hidden" value="listafacturasTodas" name="vistaProcedente">
    //                         <input type="file" name="Archivo" class="Archivo1" 
    //                               onchange="if(!this.value.length)return false; uploadFile(${idArchivo}, '${tipoArchivo}');">
    //                         ${etiqueta}
    //                       </form>
    //                     </div>`;

    //                   // Se actualiza el contenedor del input con el nuevo HTML
    //                   $('#file' + tipoArchivo + idArchivo).html(htmlNuevoInput);
    //                 } else {
    //                   Swal.fire("¡Vaya!", "El documento no pudo ser eliminado. Favor de intentarlo nuevamente.", "error");
    //                 }
    //               },
    //               error: function() {
    //                 Swal.fire("¡No eliminado!", "Ocurrió un error al borrar el documento.", "error");
    //               }
    //             });
    //           }
    //         });
    //       }
    //     }
    //   }
    // }


  //Guardar información del formulario
  function enviarForm(event){  
      console.log(event);
      // event.preventDefault()
      var proveedor=document.querySelector('#provee').value;
      if(document.getElementById('IngMen').value==''){
        swal(
          '¡No seleccionado!',
          'Seleccione una Sucursal.',
          'warning'
        );
        ;return 0;
      }
      if(proveedor==''){
        swal(
          '¡Obligatorio!',
          'Seleccione un Proveedor.',
          'warning'
        );
        //alert('SELECCIONAR UN PROVEEDOR');
        return 0;
      }
      if(document.getElementById('selectMetodoDePago').value==''){
        swal(
          '¡Obligatorio!',
          'Seleccione una Forma de Pago.',
          'warning'
        );
        //alert('SELECCIONAR UNA FORMA DE PAGO')
        ;return 0;
      }
      if(document.getElementById('folio').value==''){
        swal(
          '¡Obligatorio!',
          'Escriba el Folio.',
          'warning'
        );
        ;return 0;
      }
      if (document.getElementById('1fNacimiento').value=='') {
        swal(
          '¡Obligatorio!',
          'Seleccione la Fecha de la Factura.',
          'warning'
        );
        ;return 0;
      }
      if (document.getElementById('CargoTotalconIVA').value=='') {
        swal(
          '¡Campo vacío!',
          'Total a Pagar no puede estar vacío.',
          'warning'
        );
        ;return 0;
      }
      //console.log(proveedor);
      //huricm12-03-21
      var nombreprovedor="";
      var contacto="";
      var telefono="";
      var extencion="";
      var correo="";
      var celular="";
      var direccion="";
      var banco="";
      var cuenta="";
      var dias="";
      var giro="";
      var clave="";
      var apertura = document.querySelector('#AperturaConta').value;
      //console.log(apertura);
      var ano = document.getElementById('1fNacimiento').value;//document.querySelector('#1fNacimiento').value;
      fecha = new Date(ano);
      var anofactura = fecha.getFullYear();
      //ano =ano.getYear();
      //console.log(anofactura);
      var xhr = new XMLHttpRequest();
      var datos = new FormData();
      datos.append('id',proveedor);
      datos.append('apertura',apertura);
      xhr.open('POST',"<?php echo base_url();?>presupuestos/verificaProveedor")
      xhr.onload=function(){
        if(xhr.status === 200) {
          respuesta = JSON.parse(xhr.responseText);
          //console.log(respuesta['provedores'][0]);
          //console.log(respuesta['anodeapertura'][0]);
          // console.log(respuesta[0].NombreProveedor);
          nombreprovedor=respuesta['provedores'][0].NombreProveedor;
          contacto=respuesta['provedores'][0].Nombre_contacto;
          telefono=respuesta['provedores'][0].telefono1;
          extencion=respuesta['provedores'][0].extension;
          celular=respuesta['provedores'][0].telefono_movil;
          direccion=respuesta['provedores'][0].direccion;
          banco=respuesta['provedores'][0].banco;
          cuenta=respuesta['provedores'][0].cuenta;
          dias=respuesta['provedores'][0].DiasCredito;
          giro=respuesta['provedores'][0].giroProveedor;
          correo=respuesta['provedores'][0].email;    
          clave=respuesta['provedores'][0].clabe;  
     if(nombreprovedor=="" || contacto=="" ||telefono==""||extencion==""||celular==""||direccion==""||banco==""||cuenta==""||dias==""||correo==""||giro=="")
     {
            //console.log(nombreprovedor);
            $("#mproveedor").val(nombreprovedor);
            $("#mcontacto").val(contacto);
            $("#mtelefono").val(telefono);
            $("#mextencion").val(extencion);
            $("#mcelular").val(celular);
            $("#mcorreo").val(correo);
            $("#mdireccion").val(direccion);
            $("#mbanco").val(banco);
            $("#mcuenta").val(cuenta);
            $("#mclave").val(clave);
            $("#mdias").val(dias); 
            $("#mgiro").val(giro);
            $("#idprovee").val(proveedor);
            $(".modalProveedoor").fadeIn();
            swal({
              title: "¡No guardado!",
              text: "Primero debes actualizar la información del Proveedor para guardar la Factura.",
              icon: "warning",
              button: "OK",
            });
          }
          else{
            var formulario=document.getElementById('formreferidos');
            var tipoPago=document.getElementById('selectMetodoDePago').value;
            var bandSubmit=1;
            var folio = document.getElementById('folio').value;var fechas = document.getElementById('1fNacimiento').value;
            if(tipoPago!=''){
              if(tipoPago==3) {        
                if(folio !='' && fechas!=''){
                  bandSubmit=1;
                }  
                else{
                  swal(
                    '¡Obligatorio!',
                    'No capturaste el FOLIO o FECHA DE FACTURA.',
                    'warning'
                  );
                  //alert('No capturaste FOLIO O FECHA DE FACTURA');
                } 
              }
              if(tipoPago==0){
                bandSubmit=1;
              }
              if(tipoPago==1 || tipoPago==2 || tipoPago==4 || tipoPago==5 || tipoPago==9 ) { 
                if(fechas!=''){
                  bandSubmit=1;
                }  
                else{
                  swal(
                    '¡Obligatorio!',
                    'No capturaste la FECHA DE FACTURA o DOCUMENTO.',
                    'warning'
                  );
                  //alert('No capturaste Fecha de Factura o Documento');
                } 
              }
            }
            var id="";
            if(id!=""){
              elementosFormulario[id].focus();                         
            }else {
              event.preventDefault(); // Evita la recarga de la página

              let cadena = '';
              if (document.getElementById('tableConNotasParaFacturar')) { 
                let cant = document.getElementById('tableConNotasParaFacturar').rows.length;
                for (let i = 0; i < cant; i++) {
                  cadena += document.getElementById('tableConNotasParaFacturar').rows[i].getAttribute('data-idnotascompra') + ',';
                }
              }

              document.getElementById('textContieneNotasParaFacturar').value = cadena;
              var combo = document.getElementById("idCuentaContable");
              var selected = combo.options[combo.selectedIndex];
              let autorizado = parseFloat(selected.getAttribute('data-autorizadomes')) + parseFloat(CargoTotal.value);

              if (parseFloat(autorizado) > parseFloat(selected.getAttribute('data-montomes'))) {
                alert('Ya se superó el límite mensual');
                return; // Evita que continúe si hay error
              }
              // console.log(formulario);//Se recarga la pagina al enviar el formulario de forma tradicional
              //<----------ING ROBERTO ALVAREZ 24/MARZO/2025--------->
              guardarFacturaAlv(formulario, event);
              //<----------ING ROBERTO ALVAREZ 24/MARZO/2025--------->S
            }

          }
        }
      }
      xhr.send(datos);
      //event.currentTarget.submit();
      //Temina
      //$('#formreferidos').on('submit', function() {
        swal("¡Guardado!", "La información ha sido guardada correctamente. Espere un momento mientras se recarga la página.", "success");
      //})
    }
    //<----------ING ROBERTO ALVAREZ 21/MARZO/2025--------->
    function obtenerFacVue(){
              // ⏳ Ejecuta este bloque después de 1 segundo (1000 milisegundos)
        Swal.fire("¡Eliminado!", "La fila se borró correctamente.", "success");
        setTimeout(() => {
          if (window.vm && typeof window.vm.obtenerFacturas === 'function') {
            // console.log("Llamando a obtenerFacturas desde JS externo"); // ��️ Prueba visual en consola
            window.vm.obtenerFacturas(); // ✅ Llama al método del componente Vue
          } else {
            console.warn("No se encontró window.vm o el método obtenerFacturas"); // ⚠️ Advertencia si no existe
          }
        }, 1000); // ⏱️ Tiempo de espera en milisegundos (1 segundos)
    }
    function guardarFacturaAlv(formulario, event) {
        event.preventDefault(); // Evita el envío tradicional

        let formData = new FormData(formulario); // Captura los datos del formulario
        console.log([...formData.entries()]); // Verifica los datos antes de enviarlos

        fetch(formulario.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Respuesta del servidor no satisfactoria: " + response.status);
            }
            return response.text(); // o response.json() si esperas JSON
        })
        .then(data => {
            document.getElementById("formreferidos").reset(); // Limpiar formulario

            Swal.fire({
                title: "¡Guardado!",
                text: "La información ha sido guardada correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar"
            });

            // Recargar iframe Ya no es necesario ya que, ya no se usa un iframe, ahora se hace con un this.load de php
            // let iframe = document.getElementById("facturasFrame");
            // iframe.src = iframe.src;
             Swal.fire("¡Guardado!", "Se guardo correctamente", "success");
             window.vm.obtenerFacturas(); // ✅ Llama al método del componente Vue
        })
        .catch(error => {
            console.error("Error en la petición:", error);

            Swal.fire({
                title: "Error",
                text: "Ocurrió un problema al guardar.",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        });
    }//<----------ING ROBERTO ALVAREZ 21/MARZO/2025--------->
    
    
  /****Agregamo Automatico*************/
  function agregaAutomatico($tarea,$idusuario,$nombre,$correo){
    //var tarea =$tarea;// "Genera Correo Juan lopez"
    var xhr = new XMLHttpRequest();
    var datos = new FormData();
    datos.append('tarea',$tarea);
    datos.append('idusuario',$idusuario);
    datos.append('nombre',$nombre);
    datos.append('correo',$correo);
    xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaTareaautomatica",true);
              xhr.onload=function()
              {
                if(this.status === 200)
                {
                  var respuesta = JSON.parse(xhr.responseText);
                  //console.log(respuesta);
                }
              }
              xhr.send(datos);
            
  } 
  /****Agregamo Automatico*************/
  function calcularMontoDisponible()
  {
      var combo = document.getElementById("idCuentaContable");
      var selected = combo.options[combo.selectedIndex];    
      document.getElementById('montoMesLabel').innerHTML='$'+selected.getAttribute('data-montomes');
      document.getElementById('montoMesAutorizadoLabel').innerHTML='$'+selected.getAttribute('data-autorizadomes');
      document.getElementById('montoDisponibleLabel').innerHTML='$'+(parseFloat(selected.getAttribute('data-montomes'))-parseFloat(selected.getAttribute('data-autorizadomes'))).toFixed(2);

    
  }
  function calculaPagoDeCanal()
  {
    let subtotal=document.getElementById('CargoTotal');
    let select=document.getElementById('idCuentaContable');
    let option= select.options[select.selectedIndex];
    document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')
    document.getElementById('motivoCambioPorcentajeInput').value='';
  if(subtotal.value>0)
    {
      cargosManejoVista(false)
      let fianzas=option.getAttribute('data-fianzasporcentaje');
      let institucional=option.getAttribute('data-institucionalPorcentaje');
      let coorporativo=option.getAttribute('data-coorporativoPorcentaje');
      let gestion=option.getAttribute('data-gestionPorcentaje');
      let asesores=option.getAttribute('data-asesoresPorcentaje');
      let montoFianzas=0.00;
      let montoInstitucional=0.00;
      let montoCoorporativo=0.00;
      let montoGestion=0.00;
      let montoAsesores=0.00;
          document.getElementById('spanCargoFianzas').innerHTML=fianzas+'%';
      document.getElementById('spanCargoSeguros').innerHTML=institucional+'%';
      document.getElementById('spanCargoCoorporativo').innerHTML=coorporativo+'%';
      document.getElementById('spanCargoAsesores').innerHTML=asesores+'%';
      document.getElementById('spanCargoEspeciales').innerHTML=gestion+'%';
      if(fianzas>0){montoFianzas=(fianzas*subtotal.value)/100;}

      if(institucional>0){montoInstitucional=(institucional*subtotal.value)/100;}

      if(coorporativo>0){montoCoorporativo=(coorporativo*subtotal.value)/100;}

      if(asesores>0){montoAsesores=(asesores*subtotal.value)/100;}

      if(gestion>0){montoGestion=(gestion*subtotal.value)/100;}



      document.getElementById('CargoFianzas').value=montoFianzas.toFixed(2);
      porcentajesGlobales.fianzas=montoFianzas.toFixed(2);
      document.getElementById('CargoInst').value=montoInstitucional.toFixed(2);
      porcentajesGlobales.institucional=montoInstitucional.toFixed(2);
      document.getElementById('Corporativos').value=montoCoorporativo.toFixed(2);
      porcentajesGlobales.coorporativo=montoCoorporativo.toFixed(2);
      document.getElementById('Asesores').value=montoAsesores.toFixed(2);
      porcentajesGlobales.asesores=montoAsesores.toFixed(2);
      document.getElementById('CargoGes').value=montoGestion.toFixed(2)
      porcentajesGlobales.gestion=montoGestion.toFixed(2);
      document.getElementById('CargoTotalconIVA').value=subtotal.value; 
    }
    else{cargosManejoVista(true)}
    calcularMontoDisponible()
  }
 
  // $(function () {$(".fecha").datepicker({
  //   closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  //   monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  //   dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  //   dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  //   dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  //   dateFormat: 'dd/mm/yy',
  //   firstDay: 1,       
  // });
  // });

  function escogerRow(objeto)
  {
    if(document.getElementsByClassName('rowSeleccionado')[0]){document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado');}
    objeto.classList.add('rowSeleccionado');
  }
  function eliminarFactura(datos='')
  {
    if(datos=='')
    {
      if(document.getElementsByClassName('rowSeleccionado')[0])
    {
      let confirmacion=confirm("DESEAS ELIMINAR LA FACTURA "+document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura);
      if(confirmacion){    
      params="id="+document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura;        
      controlador="presupuestos/eliminarFactura/?";     
      peticionAJAX(controlador,params,'eliminarFactura');   
      }
    }   
      else{alert('SELECCIONE UNA FACTURA PARA ELIMINAR')}
    }
    else
    {
      if(!datos.status){alert(datos.mensaje)}
      else
      {
        let direccion='<?=base_url()?>presupuestos/Vistafacturas';
        // window.location.replace(direccion);
      }
    }
  }
  function peticionAJAX(controlador, params, funcionCallback) {
    $.ajax({
        url: ruta + controlador, // usa tu variable global `ruta` si existe
        type: 'POST',
        data: params,
        success: function (response) {
        try {
            let datos = JSON.parse(response);
            if (funcionCallback === 'traerFormasPagos') {
            traerFormasPagos(datos);
            }
        } catch (e) {
            console.error("❌ Error al parsear JSON:", response);
        }
        },
        error: function (xhr, status, error) {
        console.error("❌ Error en AJAX:", error);
        }
    });
    }



  
  
  let porcentajesGlobales=new Object();
  porcentajesGlobales.fianzas=0;
  porcentajesGlobales.institucional=0;
  porcentajesGlobales.coorporativo=0;
  porcentajesGlobales.asesores=0;
  porcentajesGlobales.Especiales=0;

  function cargosManejoVista(band=true)
  {
  document.getElementById("CargoFianzas").disabled=band;
  document.getElementById("CargoInst").disabled=band;
  document.getElementById("Corporativos").disabled=band;
  document.getElementById("Asesores").disabled=band;

  }

  
  // document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')

 

 function abrirCerrarEditarFactura(abrir=false)
 {
  if(abrir){
  document.getElementById("modalModifcaFactura").classList.remove("modalCierra");
  document.getElementById("modalModifcaFactura").classList.add("modalAbre");
   document.getElementById("modalModifcaFactura").style.display="block";
  //  window.vm.obtenerFacturas?.(); // solo si existe
   }
   else
   {
      document.getElementById("modalModifcaFactura").classList.add("modalCierra");
   document.getElementById("modalModifcaFactura").classList.remove("modalAbre");
     document.getElementById("modalModifcaFactura").style.display="none";
    //  window.vm.obtenerFacturas?.(); // solo si existe

   }
 }
 



function actualizarTablaFactura(datos)
{
  if(datos.success==1)
  {
    // alert('Actualizacion con exito de la factura');
    Swal.fire("¡Modificado!", "Se modifico correctamente", "success");
    console.log(datos);
    setTimeout(() => {
      window.vm.obtenerFacturas?.();
    }, 2000);
    
  }
}



  //---------------------------------------------------------------------------------------------------------

  function uploadFile(id,type_f) { //Creado [Suemy][2024-10-17]
    var formData = new FormData(document.getElementById("GuardarArchivo"+id));
    $.ajax({
        url: `<?=base_url()?>presupuestos/GuardarArchivo`,
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: (load) => {
        },
        success: (data) => {
            const r = JSON.parse(data);
            //console.log(r);
            let fl = r['file'];
            let type = r['status_type'];
            const format = r['format'];
            var title = "";
            var message = "";
            var status = "";
            switch(type) {
              case 1:
                title = "¡Guardado!";
                message = "Documento guardado correctamente.";
                status = "success";
                $('#file'+format+id).html(`
                  <div class="col-md-12 container-downloadFile">
                    <select class="form-control input-sm dropdownFile">
                      <option value="${fl.ruta}">Descargar</option>                                             
                      <option value="${fl.archivo}">Eliminar</option>
                    </select>
                    <button type="button" class="btn-OK" data-id="${id}" style="padding-top: 3px;margin-top: 25px;" onclick="opcionesArchivo(this)">OK</button>
                  </div>
                `);
                break;
              case 2:
                title = "¡Espera!";
                message = "El formato del documento no es válido. Favor de subir el archivo con formato PDF o XML.";
                status = "warning";
                break;
              case 3:
                title = "¡Error!";
                message = "Hay conflicto al intentar subir el documento.";
                status = "error";
                break;
            }
            Swal.fire(title,message,status);
        },
        error: (error) => {
            console.log(error);
            Swal.fire("¡Uups!", "Hay problemas al intentar guardar.", "error");
        }            
    })
  }