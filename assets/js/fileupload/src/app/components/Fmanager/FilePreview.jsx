import React from "react";

const FilePreview = ({ description, webContentLink, id, iconLink, ruta_completa }) => {

  async function DownloadDoc(URLD) {
    try {
      const newTab = window.open('', '_blank');
      newTab.document.write('<p>Preparando descarga...</p>');

      const response = await fetch(URLD);
      const blob = await response.blob();
      const blobUrl = URL.createObjectURL(blob);
      console.log(`repose ${response}| blob ${blob} | bloburl ${blobUrl}`);

      const a = newTab.document.createElement('a');
      a.href = blobUrl;
      a.download = fileName || URLD.split('/').pop() || 'documento';
      newTab.document.body.appendChild(a);
      a.click();

      setTimeout(() => {
        newTab.document.body.removeChild(a);
        URL.revokeObjectURL(blobUrl);
      }, 100);

    } catch (error) {
      console.error('Error:', error);
      window.open(URLD, '_blank'); // Fallback simple
    }
  }
  return (
    <div
      id="modal-file-manager-preview"
      className="modal moda-preview"
      tabIndex="-1"
      role="dialog"
    >
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            {description}
            <a
              //data-dismiss="modal"
              aria-label="Close"
              className="pull-right btn-sm"
              onClick={() => $('#modal-file-manager-preview').modal('hide')}
            >
              <i className="fa fa-2x fa-times" aria-hidden="true"></i>
            </a>
            {id != null && iconLink != null && (
              <a href={`https://drive.google.com/uc?id=${id}&export=download`} className="pull-right btn btn-sm">
                <i className="fa fa-2x fa-cloud-download" aria-hidden="true"></i>
              </a>
            )}
            {iconLink == null && (
              <a onClick={() => { /* DownloadDoc(ruta_completa) */window.open(ruta_completa, '_blank') }} className="pull-right btn btn-sm">
                <i className="fa fa-2x fa-cloud-download" aria-hidden="true"></i>
              </a>
            )}
          </div>
          <div className="modal-body">
            {id != null && iconLink != null && (
              <>
                {/* <p>test1</p> */}
                <iframe
                  src={`https://docs.google.com/viewer?srcid=${id}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`}
                  style={{ width: "100%", height: "90vh" }}
                  frameBorder="0"
                ></iframe>
              </>
            )}
            {iconLink == null && (
              <>
                {/*  <p>test2</p> */}
                <iframe
                  /* src={`https://docs.google.com/viewerng/viewer?url=${ruta_completa}&embedded=true`} */
                  src={ruta_completa}
                  style={{ width: "100%", height: "90vh" }}
                  frameBorder="0"
                ></iframe>
              </>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default FilePreview;
