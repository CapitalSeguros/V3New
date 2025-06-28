const firebaseConfig = {
    apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
    authDomain: "v3plus-279402.firebaseapp.com",
    databaseURL: "https://v3plus-279402.firebaseio.com",
    projectId: "v3plus-279402",
    storageBucket: "v3plus-279402.appspot.com",
    messagingSenderId: "4568272251",
    appId: "1:4568272251:web:483a7b036920897138c1de",
    measurementId: "G-8EJP31SQZ7"
  };

// Initialize Firebase
const app = firebase.initializeApp(firebaseConfig);

var storage = app.storage();
var storageRef = storage.ref("capacita_documentos_induccion");

//---------------------
var pdfDoc = null;
var pageNum = 1;
var pageRendering = false;
var pageNumPending = null;
var scale = 1.5;
var canvas = document.getElementById('doc-canvas');
var ctx = canvas.getContext('2d');
//---------------------
document.getElementById("document").addEventListener("change", function(e){

    var baseUrl = document.getElementById("base_url").getAttribute("data-base-url");
    printInViewer(baseUrl, this.value);
    console.log(this.value);
    pageNum = 1;
    //var urlDoc = storageRef.child(this.value);

    /*urlDoc.getDownloadURL().then(function(url) {
        // Insert url into an <img> tag to "download"
        console.log(url);
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
        var loadingTask = pdfjsLib.getDocument(url);
        loadingTask.promise.then(function(pdf){
            console.log("PDF Loaded", pdf);
        });
        //printInViewer(url);

      }).catch(function(error){
        console.log(error.code);
      });*/
});

function printInViewer(bU, doc){

    var _doc = `${bU}assets/documentos/capitalHumano/materialDidactico/${doc}`;

    var loadingTask = pdfjsLib.getDocument(_doc);
    loadingTask.promise.then(function(pdf){
        console.log("PDF Loaded", pdf);

        pdfDoc = pdf;
        document.querySelector(".total-pages").innerHTML = pdf.numPages;
        renderPage(pageNum);
    })

}

function renderPage(numPage){

    pageRendering = true;
    pdfDoc.getPage(numPage).then(function(page){
        var viewPort = page.getViewport({scale: scale});
        canvas.height = viewPort.height;
        canvas.width = viewPort.width;

        var renderContext = {
            canvasContext: ctx,
            viewport: viewPort
          };
    
        var renderTask = page.render(renderContext);
    
        renderTask.promise.then(function(){
            pageRendering = false;

            if(pageNumPending !== null){

                renderPage(pageNumPending);
                pageNumPending == null;
            }
        });
    });

    document.querySelector(".number-page").innerHTML = numPage;
}

function _renderClickPage(numPage_){

    if(pageRendering){
        pageNumPending = numPage_;
    } else{
        renderPage(numPage_);
    }

}

document.querySelector(".b-before").addEventListener("click", function(){

    if(pageNum <= 1){
        return false;
    }

    pageNum--;
    _renderClickPage(pageNum);
});

document.querySelector(".b-after").addEventListener("click", function(){

    if(pageNum >= pdfDoc.numPages){
        return false;
    }

    pageNum++;
    _renderClickPage(pageNum);
});

