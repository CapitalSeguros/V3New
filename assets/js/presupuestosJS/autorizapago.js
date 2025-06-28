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
            apiFactura:apiFactura,
            factura: [],
            ruta:ruta,
            gruposFacturas: [],
            collapsed: {},
        };
    },
     created() {
        // this.obtenerFacturas;
   // 
    },
    mounted() {
        this.obtenerFacturas();
    },
    watch: {
    },
    methods: {

        autorizar(factura) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción autorizará la factura.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, autorizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const rutaFactura = this.ruta + 'presupuestos/AutorizaFacVue/' + factura;

                    axios.get(rutaFactura).then(response => {
                        const verdadero = response.data;
                        if (verdadero) {
                            this.obtenerFacturas();
                            Swal.fire({
                                title: "ÉXITO", 
                                text: "Se autorizó con éxito",
                                icon: "success",
                            });
                        }
                    }).catch(error => {
                        console.error(error);
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo autorizar la factura",
                            icon: "error"
                        });
                    });
                }
            });
        },

        obtenerFacturas() {
        axios.get(this.apiFactura)
            .then(response => {
            const lista = response.data.Listafacturas;

            // Subgrupos de facturas (objeto)
            const subgruposFacturas = lista.facturas;

            // Otros grupos (arrays)
            const otrosGrupos = {
                cajaChicaMerida: lista.cajaChicaMerida || [],
                cajaChicaNorte: lista.cajaChicaNorte || [],
                cajaChicaCancun: lista.cajaChicaCancun || []
            };

            // Armar el grupo 'FACTURAS' como array de entries para que sea iterable
            const facturasEntries = Object.entries(subgruposFacturas);

            // Crear el objeto agrupado
            const agrupado = {
                FACTURAS: facturasEntries,
                ...otrosGrupos
            };

            // Convertir a array de entries donde cada contenido será un array (o array de entries)
            this.gruposFacturas = Object.entries(agrupado).map(([grupo, contenido]) => {
                // Si contenido no es array (los otros grupos son arrays, FACTURAS ya es array de entries)
                // Pero si no, convertir a entries para que sea iterable (por si hay otro caso)
                if (!Array.isArray(contenido)) {
                contenido = Object.entries(contenido);
                }
                return [grupo, contenido];
            });

            // Inicializar collapsed (desplegado)
            this.collapsed = {};
            this.gruposFacturas.forEach(([grupo, contenido]) => {
                this.collapsed[grupo] = true;//se inicializa para que todos aparescan contraidos
                if (grupo === 'FACTURAS') {
                contenido.forEach(([subgrupo]) => {
                    this.collapsed[subgrupo] = false;
                });
                }
            });
            })
            .catch(error => {
            console.error(error);
            Swal.fire({
                title: "Error",
                text: "No se pudieron obtener los datos",
                icon: "error"
            });
            });
        },

        toggleGrupo(grupo) {
            this.collapsed[grupo] = !this.collapsed[grupo];
        },
       
        // Devuelve estilos de color según nivel jerárquico
        getRowStyle(nivel) {
            const colores = [
            '#010f00',   // nivel 0: verde oscuro (grupo principal)
            '#064E03',   // nivel 1: verde medio (subgrupo)
            '#50834e'    // nivel 2: verde claro (facturas)
            ];
            return {
            backgroundColor: colores[nivel] || '#FFF',
            color: nivel === 0 ? 'white' : 'black',
            cursor: nivel < 2 ? 'pointer' : 'default'
            };
        },
        totalImporte(facturas) {
            return facturas.reduce((suma, factura) => {
            const valor = parseFloat(factura.totalconiva);
            return suma + (isNaN(valor) ? 0 : valor);
            }, 0).toFixed(2);
        },
        startDrag(event) {
            this.isDragging = true;
            this.dragStartX = event.pageX;
            this.scrollLeftStart = event.currentTarget.scrollLeft;
            event.currentTarget.style.cursor = 'grabbing';
        },
        onDrag(event) {
            if (!this.isDragging) return;
            const container = event.currentTarget;
            const walk = (event.pageX - this.dragStartX) * -1;
            container.scrollLeft = this.scrollLeftStart + walk;
        },
        stopDrag(event) {
            this.isDragging = false;
            event.currentTarget.style.cursor = 'grab';
        },
    },
    computed: {
        totalFacturas() {
            return this.gruposFacturas.reduce((sum, [_, facturas]) => sum + facturas.length, 0);
        }
    },
    });const vm = app.mount("#app");
    window.vm = vm; 