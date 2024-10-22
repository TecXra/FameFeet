export default function ({ store, redirect }) {
  if (!store.state.auth.loggedIn) {
    return redirect("/signin");
  }

  if (store.state.auth.loggedIn && store.state.auth.user.is_email_verified) {
    return redirect("/");
  }
}
