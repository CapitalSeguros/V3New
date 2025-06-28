window.onload = function () {

  'use strict';

  var Cropper = window.Cropper;
  var console = window.console || { log: function () {} };
  var container = document.querySelector('.img-container');
  var image = container.getElementsByTagName('img').item(0);
  var download = document.getElementById('imgPhoto');
  var actions = document.getElementById('actions');

  var options = {
        aspectRatio: 1 / 1,
        preview: '.img-preview',
        build: function () {
          console.log('build');
        },
        built: function () {
          console.log('built');
        },
        cropstart: function (e) {
          console.log('cropstart', e.detail.action);
        },
        cropmove: function (e) {
          console.log('cropmove', e.detail.action);
        },
        cropend: function (e) {
          console.log('cropend', e.detail.action);
        },
        crop: function (e) {
          var data = e.detail;

          console.log('crop');
          // dataX.value = Math.round(data.x);
          // dataY.value = Math.round(data.y);
          // dataHeight.value = Math.round(data.height);
          // dataWidth.value = Math.round(data.width);
          // dataRotate.value = !isUndefined(data.rotate) ? data.rotate : '';
          // dataScaleX.value = !isUndefined(data.scaleX) ? data.scaleX : '';
          // dataScaleY.value = !isUndefined(data.scaleY) ? data.scaleY : '';
        },
        zoom: function (e) {
          console.log('zoom', e.detail.ratio);
        }
      };
  var cropper = new Cropper(image, options);

  function isUndefined(obj) {
    return typeof obj === 'undefined';
  }

  function preventDefault(e) {
    if (e) {
      if (e.preventDefault) {
        e.preventDefault();
      } else {
        e.returnValue = false;
      }
    }
  }


  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();


  // Buttons
  if (!document.createElement('canvas').getContext) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }


  // Download
  if (typeof download.download === 'undefined') {
    download.className += ' disabled';
  }


  // Options
  // actions.querySelector('.docs-toggles').onclick = function (event) {
  //   var e = event || window.event;
  //   var target = e.target || e.srcElement;
  //   var cropBoxData;
  //   var canvasData;
  //   var isCheckbox;
  //   var isRadio;

  //   if (!cropper) {
  //     return;
  //   }

  //   if (target.tagName.toLowerCase() === 'span') {
  //     target = target.parentNode;
  //   }

  //   if (target.tagName.toLowerCase() === 'label') {
  //     target = target.getElementsByTagName('input').item(0);
  //   }

  //   isCheckbox = target.type === 'checkbox';
  //   isRadio = target.type === 'radio';

  //   if (isCheckbox || isRadio) {
  //     if (isCheckbox) {
  //       options[target.name] = target.checked;
  //       cropBoxData = cropper.getCropBoxData();
  //       canvasData = cropper.getCanvasData();

  //       options.built = function () {
  //         console.log('built');
  //         cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
  //       };
  //     } else {
  //       options[target.name] = target.value;
  //       options.built = function () {
  //         console.log('built');
  //       };
  //     }

  //     // Restart
  //     cropper.destroy();
  //     cropper = new Cropper(image, options);
  //   }
  // };


  // Methods
  actions.querySelector('.docs-buttons').onclick = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var result;
    var input;
    var data;

    if (!cropper) {
      return;
    }

    while (target !== this) {
      if (target.getAttribute('data-method')) {
        break;
      }

      target = target.parentNode;
    }

    if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
      return;
    }

    data = {
      method: target.getAttribute('data-method'),
      target: target.getAttribute('data-target'),
      option: target.getAttribute('data-option'),
      secondOption: target.getAttribute('data-second-option')
    };

    if (data.method) {
      if (typeof data.target !== 'undefined') {
        input = document.querySelector(data.target);

        if (!target.hasAttribute('data-option') && data.target && input) {
          try {
            data.option = JSON.parse(input.value);
          } catch (e) {
            console.log(e.message);
          }
        }
      }

      if (data.method === 'getCroppedCanvas') {
        data.option = JSON.parse(data.option);
      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'scaleX':
        case 'scaleY':
          target.setAttribute('data-option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {

          
            if (!download.disabled) {
              download.src = result.toDataURL('image/jpeg');

              image.value = null;
              cropper.reset().replace();
         

              
                var dataURL = result.toDataURL('image/jpeg');
                var blob = dataURItoBlob(dataURL);
                var urlHost = window.location.protocol +"//"+ window.location.host+"/V3/miInfo/saveImage";

                var formData = new FormData();

                formData.append('upload', blob);
            

                $.ajax({
                  async:false,
                  url: urlHost,
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (data) {
                    if(data == 'true')
                      alert('Se actualizo la foto de perfil con exito.');
                    else
                      alert('Ocurrio un error consulte con su proveedor.');
                  }
                });           

              //cropper = null;
              // Bootstrap's Modal
              $('#dvPhoto').modal('hide');
            }
          }

          break;

        case 'destroy':
          cropper = null;
          break;
      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }

    }
  };

  function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
  }

  document.body.onkeydown = function (event) {
    var e = event || window.event;

    if (!cropper || this.scrollTop > 300) {
      return;
    }

    switch (e.keyCode) {
      case 37:
        preventDefault(e);
        cropper.move(-1, 0);
        break;

      case 38:
        preventDefault(e);
        cropper.move(0, -1);
        break;

      case 39:
        preventDefault(e);
        cropper.move(1, 0);
        break;

      case 40:
        preventDefault(e);
        cropper.move(0, 1);
        break;
    }
  };


  // Import image
  var inputImage = document.getElementById('inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;

  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          cropper.reset().replace(blobURL);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }

};
