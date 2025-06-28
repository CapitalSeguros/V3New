import React, {
  useState,
  useEffect,
  useRef,
  createElement,
  cloneElement
} from "react";
import Sortable from "sortablejs";
import PropTypes from "prop-types";

const CollectionElementsCustom = ({
  list,
  children,
  addToList,
  nameSortable,
  put,
  onDrop
}) => {
  const [component, setComponent] = useState({
    created: false
  });
  const [collection, setCollection] = useState([]);
  const ref = useRef(null);

  const option = {
    group: {
      name: nameSortable,
      put: put != undefined ? put : true
    },
    animation: 150,
    onEnd: onDrop
    // onRemove: function(evt) {
    //   evt.item.parentElement.removeChild(evt.item);
    // }
  };
  useEffect(() => {
    if (ref.current != undefined && component.created == false) {
      Sortable.create(ref.current, option);
      setComponent({ created: true });
    }
  }, []);
  useEffect(() => {
    setCollection(list);
  }, [list]);

  const updateChildrenWithProps = React.Children.map(children, (child, i) => {
    return cloneElement(child, {
      key: i,
      ...child.props
    });
  });

  return createElement("ul", { ref: ref }, updateChildrenWithProps);
};

CollectionElementsCustom.prototype = {
  list: PropTypes.array.isRequired,
  addToList: PropTypes.func,
  nameSortable: PropTypes.string,
  put: PropTypes.bool
};

export default CollectionElementsCustom;
