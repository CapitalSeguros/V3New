import React from "react";
import { useField, useFormikContext } from "formik";
import DatePicker, { registerLocale } from "react-datepicker";
import es from "date-fns/locale/es";
registerLocale("es", es);

export const DatePickerField = ({ ...props }) => {
  const { setFieldValue } = useFormikContext();
  const [field] = useField(props);
  return (
    <DatePicker
      {...field}
      {...props}
      locale="es"
      peekNextMonth
      showMonthDropdown
      showYearDropdown
      dropdownMode="select"
      selected={(field.value && new Date(field.value)) || null}
      onChange={val => {
        setFieldValue(field.name, val);
      }}
    />
  );
};

export default DatePickerField;
