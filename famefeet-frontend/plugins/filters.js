import Vue from "vue";
import moment from "moment";

Vue.filter("toCurrency", function (value) {
  if (typeof value !== "number") {
    return value;
  }
  var formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  });
  return formatter.format(value);
});

// Vue.filter("formatDate", (value) => {
//   if (!value) return "";

//   // Parse the date string in a standardized format
//   const date = new Date(value);

//   // Check if the date is valid
//   if (isNaN(date.getTime())) {
//     return "Invalid Date";
//   }

//   // Format the date
//   return date.toLocaleString("en-US", {
//     month: "short",
//     day: "2-digit",
//     year: "numeric",
//     // hour: '2-digit',
//     // minute: '2-digit',
//   });
// });


// Vue.filter("formatDate", (value) => {
//   if (!value) return "";
//   return moment(value).format("MMM DD, YYYY");    
// });

Vue.filter("formatDate", (value) => {
  if (!value) return "";
  let date = value;

  // If the date is in a format that may cause issues, convert it
  if (/^\d{2}\/\d{2}\/\d{4}$/.test(date)) { // Example for "MM/DD/YYYY"
    const [month, day, year] = date.split("/");
    date = `${year}-${month}-${day}`;
  }

  return moment(date).format("MMM DD, YYYY");    
});


Vue.filter("formatTime", (value) => {
  const date = new Date(value);
  return date.toLocaleString(["en-US"], {
    hour: "2-digit",
    minute: "2-digit",
  });
});

Vue.filter("formatConverationTime", (value) => {
  const date = new Date(value);
  const now = new Date();

  const isToday = date.toDateString() === now.toDateString();
  const isYesterday = date.toDateString() === new Date(now.setDate(now.getDate() - 1)).toDateString();

  if (isToday) {
    return `${date.toLocaleTimeString("en-US", {
      hour: "2-digit",
      minute: "2-digit",
    })}`;
  } else if (isYesterday) {
    return `Yesterday`;
  } else {
    return date.toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    });
  }
});

Vue.filter("truncate", (value) => {
  if (value && value.length > 20) {
    value = value.substring(0, 15) + "...";
  }
  return value;
});

// Vue.filter("sentenceCase", function (value) {
//   var newValue = value.toUpperCase();
//   if (!value) return "";

//   const upperCaseFirstLetter = (string) =>
//     `${string.slice(0, 1).toUpperCase()}${string.slice(1)}`;

//   const lowerCaseAllWordsExceptFirstLetters = (string) =>
//     string.replaceAll(
//       /\S*/g,
//       (word) => `${word.slice(0, 1)}${word.slice(1).toLowerCase()}`
//     );
//   return upperCaseFirstLetter(lowerCaseAllWordsExceptFirstLetters(newValue));
// });
Vue.filter("toFirstLetteruppercase", function (value) {
  var newValue = value?.toUpperCase();
  if (!value) return "";

  const upperCaseFirstLetter = (string) =>
    `${string.slice(0, 1)?.toUpperCase()}${string.slice(1)}`;

  const lowerCaseAllWordsExceptFirstLetters = (string) =>
    string.replaceAll(/\S+/g, (word) =>
      word.toLowerCase() === "usps"
        ? word
        : `${word.slice(0, 1)}${word.slice(1).toLowerCase()}`
    );
  return upperCaseFirstLetter(lowerCaseAllWordsExceptFirstLetters(newValue));
});

Vue.filter("sentenceCase", function (value) {
  if (!value) return "";
  
  // Trim leading and trailing whitespace
  value = value.trim();

  // Capitalize the first letter and make the rest of the string lowercase
  return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
});
