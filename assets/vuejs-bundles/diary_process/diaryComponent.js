const { createApp, ref, mergeProps } = Vue;
const { createStore, mapState, mapActions } = Vuex;
const { createVuetify } = Vuetify;
const { useVuelidate } = Vuelidate;
const {
  required,
  email,
  alpha,
  numeric,
  integer,
  minLength,
  maxLength,
  helpers,
} = VuelidateValidators;
const diaryService = new DiaryService();

const vuetify = createVuetify({});
const store = createStore({
  state: {
    showModal: false,
    now_: moment().toDate(),
    events: [],
    idProspect: 0,
    prospecterData: {},
    contactTime: 1,
    myUser: {},
    eventData: {
      title: "",
      description: "",
      alert: false,
      timeForAlert: 5,
    },
    meetData: {
      icon: "mdi-link-off",
      label: "Ninguno",
      selected: true,
      linkRequired: false,
      openContactQuestion: false,
      code: "n",
      form: {
        link: "Ninguno",
        password: "ninguno",
      },
    },
    startDateTimeData: {
      date: moment().format("YYYY-MM-DD"),
      time: {
        hour: 8,
        minutes: "00",
      },
    },
    endDateTimeData: {
      date: moment().format("YYYY-MM-DD"),
      time: {
        hour: 8,
        minutes: "15",
      },
    },
  },
  mutations: {
    openDialog(state) {
      state.showModal = !this.state.showModal;
    },
    setEvents(state, events) {
      state.events = events;
    },
    setEventData(state, eventData) {
      state.eventData = { ...eventData };
    },
    setProspectId(state, id) {
      state.idProspect = id;
    },
    setProspecter(state, prospecter) {
      state.prospecterData = {
        ...prospecter,
        allName: `${prospecter.name} ${prospecter.lastName} ${prospecter.motherLastName}`,
        initials:
          prospecter.name !== "" || prospecter.lastName !== ""
            ? `${prospecter.name[0] ? prospecter.name[0] : ""}${
                prospecter.lastName[0] ? prospecter.lastName[0] : ""
              }`
            : "N/A",
      };
    },
    setMeetData(state, meet) {
      state.meetData = meet;
    },
    setDateTime(state, entry) {
      const key =
        entry.type == "start" ? "startDateTimeData" : "endDateTimeData";
      const state_ = state[key];
      state_[entry.node] = entry.data;
    },
    setContactTime(state, time) {
      state.contactTime = time;
    },
    setMyUser(state, user) {
      state.myUser = user;
    },
  },
  actions: {
    openDialog({ commit }) {
      commit("openDialog");
    },
    getEvents({ commit }) {
      diaryService.getEvents().subscribe((response) => {
        //console.log(response);
        commit("setEvents", response);
      });
    },
    getProspecter({ commit }, prospecterId) {
      commit("setProspectId", prospecterId);
      diaryService.getProspecter(prospecterId).subscribe((response) => {
        commit("setProspecter", response);
      });
    },
    getUsers({ commit }) {
      diaryService.getUsers().subscribe((response) => {
        console.log("users-list", response);
      });
    },
    myUser({ commit }) {
      diaryService.myUser().subscribe((response) => {
        commit("setMyUser", response);
      });
    },
    setEventData({ commit }, eventData) {
      commit("setEventData", eventData);
    },
    setMeet({ commit }, meetData) {
      commit("setMeetData", meetData);
    },
    setDateTime({ commit }, entry) {
      commit("setDateTime", entry);
    },
    setContactTimes({ commit }, time) {
      commit("setContactTime", time);
    },
    createEvent({ commit }) {
      const { meetData, eventData, startDateTimeData, endDateTimeData } =
        store.state;
      const { form } = meetData;
      let contactType = null;
      switch (meetData.code) {
        case "w":
          contactType = "whatsapp";
          break;
        case "z":
          contactType = "zoom";
          break;
        case "g":
          contactType = "meet";
          break;
        case "t":
          contactType = "phone";
          break;
      }

      const request = {
        location: null,
        startDate: store.state.startDateTimeData.date,
        startTime: store.state.startDateTimeData.time,
        endDate: store.state.endDateTimeData.date,
        endTime: store.state.endDateTimeData.time,
        contactType: contactType,
        ...eventData,
        ...(meetData.code !== "n"
          ? { meet: { meet: form.link, password: form.password } }
          : null),
        type: "prospecion",
        attendes: [store.state.myUser.id],
        service: {
          service: "prospection",
          service_id: store.state.idProspect,
          exclusiveValue: {
            tipoCCC: store.state.contactTime,
          },
        },
      };
      console.log({ request });
      return new Promise((resolve, reject) => {
        diaryService.createEvent(request).subscribe((response) => {
          console.log(response);
          resolve();
        });
      });
    },
  },
});
//---------------
const loadVueApp = () => {
  console.log("run vue app");
  const diaryApp = createApp({
    setup() {
      return {};
    },
    computed: {
      ...mapState(["showModal"]),
    },
    methods: {
      ...mapActions(["openDialog"]),
    },
  });

  diaryApp.component("dialog_", {
    data(props) {
      const min = moment().format("YYYY-MM-DD");
      const dateModel = moment().toDate();
      const changeUp = false;
      const changeDown = false;
      const newDate = new Date();
      const prevDate = new Date();
      const diary = 1;
      const showInitSelect = false;
      const showEndSelect = false;
      const startHour = 0;
      const endHour = 1;
      const hoursList = [];
      const activeList = { start: false, end: false };
      const showTooltip = false;
      const duration = {
        hour: 0,
        minute: 0,
      };

      store.dispatch("getEvents");
      store.dispatch("myUser");
      //store.dispatch("getUsers");
      //store.dispatch("getProspecter", 3130);
      return {
        min,
        dateModel,
        newDate,
        prevDate,
        changeUp,
        changeDown,
        diary,
        showInitSelect,
        showEndSelect,
        hoursList,
        startHour,
        endHour,
        activeList,
        showTooltip,
        duration,
        dateTest: [],
        //endHourList
      };
    },
    computed: {
      ...mapState(["showModal", "now_", "eventData"]),
    },
    methods: {
      ...mapActions(["openDialog", "getEvents", "getProspecter"]),
      mergeProps,
      formatDate(date) {
        const days = [
          "Domingo",
          "Lunes",
          "Martes",
          "Miércoles",
          "Jueves",
          "Viernes",
          "Sábado",
        ];
        return (
          days[date.getDay()] +
          " " +
          Intl.DateTimeFormat("es", { dateStyle: "long" }).format(date)
        );
      },
      getDate(event) {
        this.$data.newDate = event;
        store.dispatch("setDateTime", {
          type: "start",
          node: "date",
          data: moment(event).format("YYYY-MM-DD"),
        });
        store.dispatch("setDateTime", {
          type: "end",
          node: "date",
          data: moment(event).format("YYYY-MM-DD"),
        });
        this.$data.changeUp = true; //event > this.$data.prevDate;
        this.$data.changeDown = event < this.$data.prevDate;
        const resetChange = setTimeout(() => {
          this.$data.prevDate = event;
          this.$data.changeUp = false;
          this.$data.changeDown = false;
          clearTimeout(resetChange);
        }, 1000);
      },
      openHourSelect(period) {
        this.$data.showInitSelect = !this.$data.showInitSelect;
      },
      setHour(index, m) {
        if (m == "start") {
          this.$data.startHour = index;
          this.$data.endHour =
            index >= this.$data.endHour ? index + 1 : this.$data.endHour;

          store.dispatch("setDateTime", {
            type: "start",
            node: "time",
            data: {
              hour: this.$data.hoursList[this.$data.startHour].hour,
              minutes: this.$data.hoursList[this.$data.startHour].minute,
            },
          });
          store.dispatch("setDateTime", {
            type: "end",
            node: "time",
            data: {
              hour: this.$data.hoursList[this.$data.endHour].hour,
              minutes: this.$data.hoursList[this.$data.endHour].minute,
            },
          });
        }

        if (m == "end") {
          this.$data.endHour = index;
          store.dispatch("setDateTime", {
            type: "end",
            node: "time",
            data: {
              hour: this.$data.hoursList[this.$data.endHour].hour,
              minutes: this.$data.hoursList[this.$data.endHour].minute,
            },
          });
        }

        this.$data.showTooltip = true;
        this.setDuration();
      },
      setDuration() {
        let starDate = moment(this.$data.dateModel)
          .hour(this.$data.hoursList[this.$data.startHour].hour)
          .minute(this.$data.hoursList[this.$data.startHour].minute);
        let endDate = moment(this.$data.dateModel)
          .hour(this.$data.hoursList[this.$data.endHour].hour)
          .minute(this.$data.hoursList[this.$data.endHour].minute);
        this.$data.duration.hour = endDate.diff(starDate, "hours");
        this.$data.duration.minute =
          endDate.diff(starDate, "minutes") - 60 * this.$data.duration.hour;
      },
      createDaily() {
        store.dispatch("createEvent").then(() => {
          store.dispatch("openDialog");
          alert("Evento creado, revisar la agenda");
        });
      },
    },
    beforeMount() {
      this.$data.hoursList = Array.from({ length: 13 }, (v, i) => 8 + i).reduce(
        (acc, curr) => {
          acc.push(
            { hour: curr, minute: "00" },
            { hour: curr, minute: "15" },
            { hour: curr, minute: "30" },
            { hour: curr, minute: "45" }
          );
          return acc;
        },
        []
      );

      this.setDuration();
    },
    template: `
            <v-dialog v-model="showModal" class="dialog-container" persistent>
                <v-card width="auto">
                    <v-container>
                        <v-row justify="space-between">
                            <v-col cols="11">
                                <v-row>
                                    <v-col cols="1" align-self="center" class="p-0 ps-2">
                                        <v-row justify="center" no-gutters><i class="fa fa-calendar-plus-o fa-3x"></i></v-row>
                                    </v-col>
                                    <v-col cols="10">
                                        <v-col cols="12" class="custom-card-header">Genere una reunión</v-col>
                                        <v-col cols="12" class="custom-card-sub-header">Configure una reunión con el prospecto</v-col>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="auto" align-self="center"><span style="cursor: pointer" @click="openDialog"><i class="fa fa-times fa-lg"></i></span></v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6" justify="center">
                                <v-card>
                                    <h3 class="change-date" :class="{'change-date-animation-up': changeUp}">{{formatDate(newDate)}}</h3>
                                    <v-tooltip :location="activeList.start || activeList.end ? 'top' : 'bottom'" :content-class="{'hour-text': true}" v-model="showTooltip"> <!-- 'hour-tooltip-up': activeList.start || activeList.end, 'hour-tooltip-bottom': !activeList.start && !activeList.end -->
                                        <template v-slot:activator="{props: tooltip}">
                                            <v-row justify="center" class="py-2" v-bind="mergeProps(tooltip)" style="font-size: 20px">
                                                <v-col cols="auto" class="p-1">
                                                    <v-menu max-height="300px" open-on-click @update:modelValue="activeList.start = $event">
                                                        <template v-slot:activator="{props: menu}">
                                                            <span class="hour-hover p-1" v-bind="mergeProps(menu)" :class="{'hour-border': activeList.start}">{{hoursList[startHour].hour}}:{{hoursList[startHour].minute}}</span>
                                                        </template>
                                                        <v-list>
                                                            <v-list-item v-for="(item, index) in hoursList" :key="index" :value="index" density="compact" :active="startHour == index" @click="setHour(index, 'start')">
                                                                <v-list-item-title style="font-size: 17px">{{item.hour}}:{{item.minute}}</v-list-item-title>
                                                            </v-list-item>
                                                        </v-list>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="auto" class="p-1">-</v-col>
                                                <v-col cols="auto" class="p-1">
                                                    <v-menu max-height="300px" open-on-click @update:modelValue="activeList.end = $event">
                                                        <template v-slot:activator="{props: menu}">
                                                            <span class="hour-hover p-1" v-bind="mergeProps(menu)" :class="{'hour-border': activeList.end}">{{hoursList[endHour].hour}}:{{hoursList[endHour].minute}}</span>
                                                        </template>
                                                        <v-list>
                                                            <template v-for="(item, index) in hoursList">
                                                                <v-list-item  v-if="index >= startHour" :key="index" :value="index" density="compact" :active="endHour == index" @click="setHour(index, 'end')">
                                                                    <v-list-item-title style="font-size: 17px">{{item.hour}}:{{item.minute}}</v-list-item-title>
                                                                </v-list-item>
                                                            </template>
                                                        </v-list>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="auto" class="p-1">horas</v-col>
                                            </v-row>
                                        </template>
                                        <span>Duración: {{duration.hour}} hrs, {{duration.minute}} min</span>
                                    </v-tooltip>
                                    <v-row justify="center" class="m-0" v-if="eventData.alert">
                                      <v-col cols="5" class="p-0 py-1 border rounded-pill px-3 text-center mt-2"><i class="fa fa-clock-o"></i> Alertar {{eventData.timeForAlert}} min antes</v-col>
                                    </v-row>
                                    <v-row justify="center"><v-date-picker hide-header :min="min" v-model="dateModel" show-adjacent-months @update:modelValue="getDate"></v-date-picker></v-row>
                                    <!--<v-row justify="center"><v-date-picker hide-header :min="min" v-model="dateTest" show-adjacent-months multiple="range"></v-date-picker></v-row>-->
                                </v-card>
                            </v-col>
                            <v-col cols="6" class="px-6">
                                <v-col cols="auto" class="px-0 pt-0">
                                    <meet-details></meet-details>
                                </v-col>
                                <v-col cols="auto" class="px-0">
                                    <prospecter></prospecter>
                                </v-col>
                                <v-col cols="auto" class="px-0">
                                    <way-of-contact></way-of-contact>
                                </v-col>
                                <v-col cols="auto" class="px-0">
                                    <guest></guest>
                                </v-col>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-card-actions class="px-8">
                      <v-spacer></v-spacer>
                      <v-btn>Cancelar</v-btn>
                      <v-btn style="color: blue" @click="createDaily">Crear reunión</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        `,
  });

  diaryApp.component("meet-details", {
    data() {
      const open = store.state.eventData.title === "";
      const event = {
        title: "",
        description: "",
        alert: false,
        timeForAlert: 5,
      };
      return { event, open };
    },
    computed: {
      ...mapState(["eventData"]),
    },
    methods: {
      setEvent() {
        store.dispatch("setEventData", this.$data.event);
        this.$data.open = false;
      },
      cancellProccess() {
        //open = false;
        this.$data.event = Object.assign({}, store.state.eventData);
        this.$data.open = false;
      },
    },
    template: `
            <v-card>
                <v-card-title>
                    <v-row>
                        <v-col cols="10"><h4>Detalle de la reunión</h4></v-col>
                        <v-col cols="2">
                            <v-menu open-on-click location="bottom" :close-on-content-click="false" v-model="open">
                                <template v-slot:activator="{props}">
                                    <v-row justify="center">
                                        <v-col align="center">
                                            <v-btn icon="mdi-pencil" variant="text" density="compact" v-bind="props"></v-btn>
                                        </v-col>
                                    </v-row>
                                </template>
                                <v-card min-width="300" max-width="300">
                                    <v-card-title><h4>Editar reunión</h4></v-card-title>
                                    <v-card-text>
                                        <v-col cols="12" class="py-0">
                                            <h5>Título</h5>
                                            <v-text-field clearable variant="outlined" density="compact" v-model="event.title"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <h5>Comentario - detalle</h5>
                                            <v-textarea clearable variant="outlined" rows="1" v-model="event.description"></v-textarea>
                                        </v-col>
                                        <v-col cols="12" class="py-0 ps-0">
                                          <v-checkbox v-model="event.alert">
                                            <template v-slot:label>
                                              <span class="text-h5" :class="{'text-black font-weight-medium': event.alert}">Alertar 10 minutos antes de la hora</span>
                                            </template>
                                          </v-checkbox>
                                        </v-col>
                                    </v-card-text>
                                    <v-card-actions style="justify-content: end; font-weight: bold">
                                        <v-btn variant="text" size="small" style="font-size: 10px" @click="cancellProccess">Cancelar</v-btn>
                                        <v-btn variant="text" size="small" style="color: blue; font-size: 10px" @click="setEvent">Confirmar</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-menu>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-col cols="12" class="py-2">
                        <span style="font-size: 14px; max-width: inherit" class="d-inline-block text-truncate">Título: {{eventData.title}}</span>
                    </v-col>
                    <v-col cols="12" class="py-2">
                        <span style="font-size: 14px; max-width: inherit" class="d-inline-block text-truncate">Comentario: {{eventData.description}}</span>
                    </v-col>
                </v-card-text>
            </v-card>
        `,
  });

  diaryApp.component("prospecter", {
    data() {
      const avatarLetters = "";
      const open = false;
      return { avatarLetters, open };
    },
    computed: {
      ...mapState(["prospecterData", "contactTime"]),
    },
    methods: {
      ...mapActions(["setContactTimes"]),
    },
    template: `
            <v-menu location="end" :open-on-hover="true" :close-on-content-click="false" :close-on-back="false" v-model="open">
                <template v-slot:activator="{props}">
                    <v-card  v-bind="props">
                        <v-card-text>
                            <v-row>
                              <v-col cols="10">
                                <h4 class="mt-0">Contacto con prospecto: <v-icon icon="mdi mdi-calendar" size="small"></v-icon> {{contactTime}}° contacto</h4>
                                <v-row justify="center">
                                  <v-col cols="auto" class="px-5">
                                    <v-btn variant="flat" size="small" color="blue-darken-2" @click="setContactTimes(1)">1° contacto</v-btn>
                                  </v-col>
                                  <v-col cols="auto" class="px-5">
                                    <v-btn variant="flat" size="small" color="blue-darken-2" @click="setContactTimes(2)">2° contacto</v-btn>
                                  </v-col>
                                </v-row>
                              </v-col>
                              <v-col cols="auto" align-self="center"><v-avatar color="surface-variant">{{prospecterData.initials}}</v-avatar></v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </template>
                <v-card min-width="230" max-width="230">
                    <v-card-title>
                        <v-col class="p-0">
                            <v-row no-gutters>
                                <v-col><h4>Prospecto</h4></v-col>
                                <v-col cols="auto" align-self="center"><v-btn icon="mdi-close" variant="text" density="compact" @click="open = false;"></v-btn></v-col>
                            </v-row>
                        </v-col>
                    </v-card-title>
                    <v-card-text>
                        <v-col cols="12">
                            <v-row justify="center">
                                <v-avatar size="70" color="surface-variant" style="font-size: 15px">{{prospecterData.initials}}</v-avatar>
                            </v-row>
                        </v-col>
                        <v-col cols="12" class="px-0 mt-3">
                            <v-row justify="center" no-gutters class="mb-2">
                                <v-col cols="5" class="text-h6">Nombre:</v-col>
                                <v-col cols="7" class="text-h6">{{prospecterData.allName}}</v-col>
                            </v-row>
                            <v-row justify="center" no-gutters class="mb-2">
                                <v-col cols="5" class="text-h6">Correo:</v-col>
                                <v-menu :open-on-hover="true" :close-on-content-click="false" location="bottom">
                                    <template v-slot:activator="{props}">
                                        <v-col cols="7" class="text-h6" v-bind="props"><span style="max-width: inherit" class="d-inline-block text-truncate">{{prospecterData.email}}</span></v-col>
                                    </template>
                                    <v-card><v-card-title>{{prospecterData.email}}</v-card-title></v-card>
                                </v-menu>
                            </v-row>
                            <v-row justify="center" no-gutters class="mb-2">
                                <v-col cols="5" class="text-h6">Teléfono:</v-col>
                                <v-col cols="7" class="text-h6">{{prospecterData.phone}}</v-col>
                            </v-row>
                            <v-row justify="center" no-gutters class="mb-2">
                                <v-col cols="5" class="text-h6">Tipo de prospecto:</v-col>
                                <v-col cols="7" class="text-h6" align-self="center">{{prospecterData.entity}}</v-col>
                            </v-row>
                            <v-row justify="center" no-gutters class="mb-2">
                                <v-col cols="5" class="text-h6">Estado actual:</v-col>
                                <v-col cols="7" class="text-h6">{{prospecterData.state}}</v-col>
                            </v-row>
                        </v-col>
                    </v-card-text>
                </v-card>
            </v-menu>
        `,
  });

  diaryApp.component("way-of-contact", {
    setup() {
      const v$ = useVuelidate();
      return {
        v$,
      };
    },
    data() {
      const openContactForm = false;
      const openChangeContact = false;
      const opened = [];
      const nolink = false;
      //const show2 = false;
      const contactsPlatform = [
        {
          icon: "mdi-whatsapp",
          label: "Whatsapp",
          selected: false,
          linkRequired: false,
          openContactQuestion: false,
          code: "w",
          form: {
            link: "",
            password: "",
          },
        },
        {
          icon: "mdi-video",
          label: "Zoom meet",
          selected: false,
          linkRequired: true,
          openContactQuestion: false,
          code: "z",
          form: {
            link: "",
            password: "",
          },
        },
        {
          icon: "mdi-google",
          label: "Google meet",
          selected: false,
          linkRequired: true,
          openContactQuestion: false,
          code: "g",
          form: {
            link: "",
            password: "",
          },
        },
        {
          icon: "mdi-phone",
          label: "Llamada telefónica",
          selected: false,
          linkRequired: false,
          openContactQuestion: false,
          code: "t",
          form: {
            link: "",
            password: "",
          },
        },
        {
          icon: "mdi-link-off",
          label: "Ninguno",
          selected: true,
          linkRequired: false,
          openContactQuestion: false,
          code: "n",
          form: {
            link: "Ninguno",
            password: "Ninguno",
          },
        },
      ];
      const contact_ = contactsPlatform.find((ob) => ob.selected);
      const linkForm = {
        link: "",
        password: "",
      };
      return {
        openChangeContact,
        contactsPlatform,
        openContactForm,
        opened,
        nolink,
        //show2,
        contact_,
        linkForm,
      };
    },
    validations: {
      linkForm: {
        link: { required },
      },
    },
    computed: {
      ...mapState(["prospecterData", "meetData"]),
    },
    methods: {
      //mergeProps,
      selectContact(contact) {
        this.$data.opened = [];
        this.$data.contactsPlatform.map((co) => {
          co.selected = co.label == contact.label;
          co.openContactQuestion = co.label == contact.label;

          if (co.label == contact.label) {
            this.$data.opened.push(contact.code);
          }

          return co;
        });
        this.$data.contact_ = this.$data.contactsPlatform.find(
          (ob) => ob.selected
        );
      },
      confirmContact() {
        const contact = this.$data.contactsPlatform.find((ob) => ob.selected);

        if (contact.linkRequired && contact.form.link == "") {
          console.log("No se cargó liga de reunión");
          this.$data.nolink = true;
          return false;
        }

        store.dispatch("setMeet", {
          ...contact,
          form: {
            link: ["w", "t"].includes(contact.code)
              ? "Contacto al no. " + this.prospecterData.phone
              : ["z", "g"].includes(contact.code)
              ? contact.form.link
              : "Ninguno",
            password:
              ["z", "g"].includes(contact.code) && contact.form.password !== ""
                ? contact.form.password
                : "Ninguno",
          },
        });
        this.$data.openChangeContact = false;
      },
      openLinkForm() {
        this.$data.openContactForm = true;
        this.$data.linkForm = { ...this.$data.contact_.form };
      },
      async confirmMeet() {
        this.v$.$validate();

        if (this.v$.$error) {
          return false;
        }

        this.$data.contactsPlatform.map((ob) => {
          ob.form = ob.selected ? { ...this.$data.linkForm } : ob.form;
        });

        this.$data.nolink = false;
        this.closeProcess();
      },
      closeProcess() {
        this.v$.$reset();
        this.$data.linkForm.link = "";
        this.$data.linkForm.password = "";
        this.$data.openContactForm = false;
      },
    },
    template: `
        <v-menu :close-on-content-click="false" location="bottom" v-model="openChangeContact" :open-on-click="true">
            <template v-slot:activator="{props}">
                <v-card>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" class="py-0"><h4 style="margin-bottom: 0px">Contacto por: {{meetData.label}}</h4></v-col>
                            <v-col cols="auto" align-self="center">
                                <v-avatar color="blue-darken-2" style="font-size: 18px; position: relative">
                                    <v-icon :icon="meetData.icon"></v-icon>
                                </v-avatar>
                                <div type="button" class="change-contact" style="position: absolute" v-bind="props"><v-icon icon="mdi-pencil"></v-icon></div>
                            </v-col>
                            <v-col cols="9">
                                <v-row>
                                    <v-col cols="12" class="pb-1 text-h5"><span style="max-width: inherit" class="d-inline-block text-truncate">Reunión: {{meetData.form.link}}</span></v-col>
                                    <v-col cols="12" class="pt-1 text-h5"><span style="max-width: inherit" class="d-inline-block text-truncate">Contraseña: {{meetData.form.password}}</span></v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="1" align-self="center" class="px-0" v-if="meetData.linkRequired">
                                <v-btn icon="mdi-content-copy" variant="text" density="compact"></v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>    
            </template>
            <v-card min-width="230" max-width="230">
                <v-list v-model:opened="opened">
                    <template v-for="(contact, index) in contactsPlatform">
                        <v-list-item class="cursor-pointer"  @click="selectContact(contact)" v-if="!contact.linkRequired" type="button">
                            <v-row >
                                <v-col cols="auto"><v-icon :icon="contact.icon" size="x-large"></v-icon></v-col>
                                <v-col cols="9" class="font-weight-bold px-0" align-self="center">
                                    {{contact.label}} <v-icon v-if="contact.selected" icon="mdi-check" style="color: green"></v-icon>
                                </v-col>
                            </v-row>
                        </v-list-item>
                        <v-list-group v-if="contact.linkRequired" collapse-icon="" expand-icon="" :fluid="true" :value="contact.code">
                            <template v-slot:activator="{ props }">
                                <v-list-item v-bind="props"  class="cursor-pointer"  @click="selectContact(contact)" type="button">
                                    <v-row >
                                        <v-col cols="auto"><v-icon :icon="contact.icon" size="x-large"></v-icon></v-col>
                                        <v-col cols="9" class="font-weight-bold px-0" align-self="center">
                                            {{contact.label}} <v-icon v-if="contact.selected" icon="mdi-check" style="color: green"></v-icon><v-icon v-if="contact.form.link !== ''" icon="mdi-link"></v-icon>
                                        </v-col>
                                    </v-row>
                                </v-list-item>
                            </template>
                            <v-list-item class="cursor-pointer" :class="{'link-required': contact.selected && nolink}" :key="'option-' + index" :value="index" @click="openLinkForm">
                                <v-row class="ms-3">
                                    <v-col cols="auto"><v-icon icon="mdi-subdirectory-arrow-right" size="x-large"></v-icon></v-col>
                                    <v-col cols="8" class="font-weight-bold px-0" align-self="center">
                                        Agregar o modificar liga de reunión 
                                    </v-col>
                                </v-row>
                            </v-list-item>
                        </v-list-group>
                    </template>
                </v-list>
                <v-card-actions style="justify-content: end; font-weight: bold">
                    <v-btn variant="text" size="small" style="font-size: 10px" @click="openChangeContact = false">Cancelar</v-btn>
                    <v-btn variant="text" size="small" style="color: blue; font-size: 10px" @click="confirmContact">Confirmar</v-btn>
                </v-card-actions>
            </v-card>
        </v-menu>
        <v-dialog width="30%" v-model="openContactForm">
            <v-card>
                <v-card-title>
                    <v-col>
                        <v-row>
                            <v-col cols="auto" style="font-size: 20px" align-self="center">
                                <v-icon :icon="contact_.icon"></v-icon>
                            </v-col>
                            <v-col>
                                <v-col class="p-0 text-h5 font-weight-bold">{{contact_.label}}</v-col>
                                <v-col class="p-0 text-h6">El campo de liga es obligatorio</v-col>
                            </v-col>
                            <v-col cols="auto" align-self="center"><v-btn icon="mdi-close" variant="text" density="compact" @click="closeProcess"></v-btn></v-col>
                        </v-row>
                    </v-col>
                </v-card-title>
                <v-card-text>
                    <v-col>
                        <v-menu location="end" :close-on-content-click="false" :modelValue="linkForm.link !== ''" open-on-click max-width="500">
                            <template v-slot:activator="{props}">
                                <div v-if="v$.linkForm.link.$error">
                                    <div v-if="v$.linkForm.link.required.$invalid" class="text-danger"><small>El campo de link es requerido</small></div>
                                </div>
                                <v-text-field
                                    density="compact"
                                    placeholder="URL de video conferencia"
                                    prepend-inner-icon="mdi-link"
                                    variant="outlined"
                                    id="link_"
                                    v-bind="props"
                                    v-model="linkForm.link"
                                ></v-text-field>
                            </template>
                            <v-card>
                                <v-card-text>
                                    <v-col>
                                        <h5><v-icon icon="mdi-link"></v-icon></h5>
                                        <p>{{linkForm.link}}</p>
                                    </v-col>
                                </v-card-text>
                            </v-card>
                        </v-menu>
                        <v-menu location="end" :close-on-content-click="false" :modelValue="linkForm.password !== ''" open-on-click max-width="500">
                            <template v-slot:activator="{props}">
                                <v-text-field
                                    density="compact"
                                    placeholder="Contraseña (opcional)"
                                    prepend-inner-icon="mdi-key"
                                    variant="outlined"
                                    v-bind="props"
                                    v-model="linkForm.password"
                                ></v-text-field>
                            </template>
                            <v-card>
                                <v-card-text>
                                    <v-col>
                                        <h5><v-icon icon="mdi-key"></v-icon></h5>
                                        <p>{{linkForm.password}}</p>
                                    </v-col>
                                </v-card-text>
                            </v-card>
                        </v-menu>
                    </v-col>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" size="small" style="font-size: 10px" @click="closeProcess">Cancelar</v-btn>
                    <v-btn variant="text" size="small" style="color: blue; font-size: 10px" @click="confirmMeet">Confirmar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    `,
  });

  diaryApp.component("guest", {
    data() {
      return {};
    },
    methods: {},
    mounted() {},
    template: `
        <v-card>
            <v-card-title>
                <h4>Participantes</h4>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="auto">
                        <v-avatar color="surface-variant">DC</v-avatar>
                    </v-col>
                    <v-col cols="10">
                        <v-col class="pa-0"><p class="text-h5 ma-0">Usted</p></v-col>
                        <v-col class="pa-0"><p class="text-h6 ma-0 d-inline-block text-truncate" style="max-width: inherit;">DIRECTORGENERAL@ASESORESCAPITAL.COM</p></v-col>
                        <v-row>
                          <v-col cols="7"><p class="text-h6">Al guardar cambios, el estado de participación pasa a ser: </p></v-col>
                          <v-col cols="5" class="ps-1 pe-0" align-self="center" justify="center"><span class="py-1 px-3 text-h6 rounded-pill border text-white bg-success">Confirmado</span></v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    `,
  });

  diaryApp.use(store).use(vuetify).mount("#main-app");
  var prospecters = document.getElementsByClassName("generateEvent");
  for (var a = 0; a < prospecters.length; a++) {
    prospecters[a].addEventListener("click", (event) => {
      store.dispatch("openDialog");
      store.dispatch("getProspecter", event.target.getAttribute("p"));
    });
  }
};
