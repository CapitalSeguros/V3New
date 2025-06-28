const fetch = require("node-fetch");
const app = require("express")();
const Dropbox = require("dropbox");

const hostname = "localhost";
const port = 3000;

const config ={
    fetch,
    clientId: "n2kqfsrmd1x2tho",
    clientSecret: "3lwnj8t7s99tfxo",
}

const dbx = new Dropbox(config);
const redirectURI = `http://${hostname}:${port}/auth`;

app.get("/", (req, res) => { //initial page

    dbx.auth.getAuthenticationUrl(redirectURI, null, "code", "offline", null, "none", false)
        .then((result) => {
            console.log("PRINCIPAL-", result);
            res.writeHead(302, { Location: authUrl });
            res.end();
        }).catch((err) => {
            console.log("Error - PRINCIPAL", error);
        });
});

app.get("/auth", (request, response) => {

    const { code } = request.query();
    console.log("CODE:", code);
});

app.listen(port);