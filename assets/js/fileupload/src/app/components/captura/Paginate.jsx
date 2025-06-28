import React from 'react';
import ReactPaginate from 'react-paginate';

export default function Paginate(props) {
    const { handlePageClick, pageCount } = props;
    return (
        <ReactPaginate
                breakLabel="..."
                nextLabel=">"
                onPageChange={handlePageClick}
                pageRangeDisplayed={3}
                pageCount={pageCount}
                previousLabel="<"
                renderOnZeroPageCount={null}
                className={"pagination"}
                pageClassName={"paginate_button page-item"}
                pageLinkClassName={"page-link"}
                previousClassName={"paginate_button page-item previous"}
                previousLinkClassName={"page-link"}
                nextLinkClassName={"page-link"}
                nextClassName={"paginate_button page-item next"}
                activeClassName={"paginate_button page-item active"}
            />
    )
}