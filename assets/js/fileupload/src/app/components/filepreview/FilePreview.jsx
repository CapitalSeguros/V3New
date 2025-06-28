import React from 'react'

const FilePreview = (props) => {

    return(
        <div id="mdPrevies" className="modal moda-preview" tabIndex="-1" role="dialog">
    <div className="modal-dialog" role="document">
    <div className="modal-content">
        <div className="modal-header">{props.description}
        <a data-dismiss="modal" aria-label="Close" className="pull-right btn-sm"><i className="fa fa-2x fa-times" aria-hidden="true"></i></a>
        <a href={props.download} className="pull-right btn-sm"><i className="fa fa-2x fa-cloud-download" aria-hidden="true"></i></a>
        </div>
        <div className="modal-body">
        <iframe src={`https://docs.google.com/viewer?url=${props.urlFile}&embedded=true`} style={{'width':'100%', 'height':'90vh'}} frameBorder="0"></iframe>
        </div>
    </div>
    </div>
</div>
    )
};

export default FilePreview;