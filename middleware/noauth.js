export default function({ store, redirect }) {
  if (!store.getters.isAuth) {
    return true;
  } else {
    if (store.state.auth.user.roles === "guru") {
      return redirect("/guru");
    }
    if (store.state.auth.user.roles === "siswa") {
      return redirect("/siswa");
    }
  }
}
