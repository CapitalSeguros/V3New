import React from "react";

const FilePreview = ({ description, webContentLink, id }) => {
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
              data-dismiss="modal"
              aria-label="Close"
              className="pull-right btn-sm"
            >
              <i className="fa fa-2x fa-times" aria-hidden="true"></i>
            </a>
            <a href={`https://drive.google.com/uc?id=${id}&export=download`} className="pull-right btn btn-sm">
              <i className="fa fa-2x fa-cloud-download" aria-hidden="true"></i>
            </a>
          </div>
          <div className="modal-body">
            {id &&(
              <>
                <iframe
                src={`https://docs.google.com/viewer?srcid=${id}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`}
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
