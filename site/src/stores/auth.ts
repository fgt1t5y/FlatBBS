import { defineStore } from "pinia";
import { get, set } from "./utils";

defineStore("auth", {
  state: () => ({
    _user_status: "0",
  }),
  actions: {
    load() {
      this._user_status = get("_user_status", "0");
    },
    save(status: string) {
      this._user_status = set("_user_status", status);
    },
  },
});
