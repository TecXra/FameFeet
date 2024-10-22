export default function ({ store, redirect }) {
	if (store.state.auth.loggedIn && !store.state.auth.user.is_email_verified) {
		return redirect("/auth/email-verification");
	}
	if (
		store.state.auth.loggedIn &&
		!store.state.auth.user.is_profile_completed
	  ) {
		console.log(store.state.auth.user);
		return redirect("/fan/settings/profile");
	  }
}