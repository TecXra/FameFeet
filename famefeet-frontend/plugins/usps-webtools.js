const USPS = require("usps-webtools");

window.usps = new USPS({
  server: process.env.USPS_SERVER,
  userId: process.env.USPS_USERID,
  ttl: 10000,
});
// console.log(usps);
