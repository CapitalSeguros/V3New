const { range, filter, map } = rxjs;
const { ajax } = rxjs.ajax;
const cookie = new UniversalCookie();

class DiaryService {
  token;
  headersConfig;
  constructor() {
    this.token = cookie.get("login_account");
    this.headersConfig = {
      headers: {
        "Session-User": this.token,
        "Content-Type": "application/json",
      },
    };
  }

  getEvents = () => {
    return ajax({
      //url: "http://localhost/Capsys/www/V3/api/calendar/events",
      //url: "http://v3.capsys.site/api/calendar/events",
      url: "https://capsys.com.mx/V3/api/calendar/events",
      method: "GET",
      ...this.headersConfig,
    }).pipe(
      map((response) => {
        return response.response;
      })
    );
  };

  getProspecter = (prospecterID) => {
    return ajax({
      //url: `http://localhost/Capsys/www/V3/api/prospection/client/${prospecterID}`,
      //url: `http://v3.capsys.site/api/prospection/client/${prospecterID}`,
      url: `https://capsys.com.mx/V3/api/prospection/client/${prospecterID}`,
      method: "GET",
      ...this.headersConfig,
    }).pipe(
      map((response) => {
        return response.response;
      })
    );
  };

  getUsers = () => {
    return ajax({
      //url: `http://localhost/Capsys/www/V3/api/users`,
      //url: `http://v3.capsys.site/api/users`,
      url: `https://capsys.com.mx/V3/api/users`,
      method: "GET",
      ...this.headersConfig,
    }).pipe(
      map((response) => {
        return response.response;
      })
    );
  };

  myUser = () => {
    return ajax({
      //url: "http://localhost/Capsys/www/V3/api/user/myUser",
      //url: `http://v3.capsys.site/api/user/myUser`,
      url: `https://capsys.com.mx/V3/api/user/myUser`,
      method: "GET",
      ...this.headersConfig,
    }).pipe(map((response) => response.response));
  };

  createEvent = (request) => {
    return ajax({
      //url: "http://localhost/Capsys/www/V3/api/calendar/events",
      //url: "http://v3.capsys.site/api/calendar/events",
      url: "https://capsys.com.mx/V3/api/calendar/events",
      method: "POST",
      ...this.headersConfig,
      body: request,
    }).pipe(map((response) => response.response));
  };
}
