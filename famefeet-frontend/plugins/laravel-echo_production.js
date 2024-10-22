import Echo from 'laravel-echo';
import io from 'socket.io-client';


const host = process.env.BACKEND_HOST;
const port = process.env.LARAVEL_ECHO_PORT;

export const initializeEcho = (token) => {
  window.io = io;
  const echo = new Echo({
    broadcaster: 'socket.io',
    host: `${host}:${port}`,
    auth: {
      headers: {
        Authorization: `${token}`
      }
    }
  });

  return echo;
};

// import Echo from "laravel-echo";

// var host = process.env.BACKEND_HOST;
// var port = process.env.LARAVEL_ECHO_PORT;

// window.io = require("socket.io-client");
// window.Echo = new Echo({
//   broadcaster: "socket.io",
//   host: host ,

// });