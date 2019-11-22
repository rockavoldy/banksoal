export default function({ store, redirect }) {
  if (!store.getters.isAuth) {
    return redirect("/");
  } else {
    if (store.state.auth.user.roles !== "siswa") {
      return redirect("/");
    } else {
      return true;
    }
  }
}
