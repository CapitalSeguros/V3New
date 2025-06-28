import React from "react";

const ItemGrid = ({ item }) => {
  return (
    <li className="media">
      <div className="media-left">
        <a href="#">
          <img
            className="media-object"
            src={item.hasThumbnail ? item.thumbnailLink : item.iconLink}
            alt={item.name}
          />
        </a>
      </div>
      <div className="media-body">
        <h4 className="media-heading">{item.name}</h4>
        <small>{item.fileExtension}</small>
      </div>
    </li>
  );
};
export default ItemGrid;
