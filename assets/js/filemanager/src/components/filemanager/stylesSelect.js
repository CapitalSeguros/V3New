export function stylesSelect(valor,type,normal=null){
  const colourStyles = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px",
      borderColor:type==1?'':'#a94442 !important'
    }),
    groupHeading:styles=>({
      ...styles,
      color:'#472380 !important',
      fontWeight:'bold',
      fontSize:'13px',
      textTransform:'capitalize'
    }),
    option:styles=>({
      ...styles,
      marginLeft:normal==null?'':"10px",
      fontSize:"12px",
      wordWrap: "break-word",
      width:normal==null?'':`${valor}`,
    }),
    menu: base => ({
      ...base,
      borderRadius: 0,
      hyphens: "auto",
      marginTop: 0,
      textAlign: "left",
    }),
    menuList: base => ({
      ...base,
      padding: 0
    })
  };

  return colourStyles;
}