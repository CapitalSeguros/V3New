import React, { Component, useState } from "react";
import values from "lodash/values";
import PropTypes from "prop-types";
import TreeNode from "./TreeNode.jsx";

const data = {
  "/root": {
    path: "/root",
    type: "folder",
    isRoot: true,
    children: ["/root/david", "/root/jslancer"],
  },
  "/root/david": {
    path: "/root/david",
    type: "folder",
    children: ["/root/david/readme.md"],
  },
  "/root/david/readme.md": {
    path: "/root/david/readme.md",
    type: "file",
    content: "Thanks for reading me me. But there is nothing here.",
  },
  "/root/jslancer": {
    path: "/root/jslancer",
    type: "folder",
    children: ["/root/jslancer/projects", "/root/jslancer/vblogs"],
  },
  "/root/jslancer/projects": {
    path: "/root/jslancer/projects",
    type: "folder",
    children: ["/root/jslancer/projects/treeview"],
  },
  "/root/jslancer/projects/treeview": {
    path: "/root/jslancer/projects/treeview",
    type: "folder",
    children: [],
  },
  "/root/jslancer/vblogs": {
    path: "/root/jslancer/vblogs",
    type: "folder",
    children: [],
  },
};

const Tree = ({ onSelect }) => {
  const [state, setState] = useState({ nodes: data });

  function getRootNodes() {
    const { nodes } = state;
    return values(nodes).filter((node) => node.isRoot === true);
  }

  function getChildNodes(node) {
    const { nodes } = state;
    if (!node.children) return [];
    return node.children.map((path) => nodes[path]);
  }

  function onToggle(node) {
    const { nodes } = state;
    nodes[node.path].isOpen = !node.isOpen;
    setState({ nodes });
  }

  function onNodeSelect(node) {
    onSelect(node);
  }

  return (
    <div>
      {getRootNodes().map((node, key) => (
        <TreeNode
          key={key}
          node={node}
          getChildNodes={getChildNodes}
          onToggle={onToggle}
          onNodeSelect={onNodeSelect}
        />
      ))}
    </div>
  );
};

Tree.propTypes = {
  onSelect: PropTypes.func.isRequired,
};
export default Tree;
