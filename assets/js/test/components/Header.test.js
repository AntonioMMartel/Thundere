import Header from '../../vue/components/Header.vue';
import NavButton from '../../vue/components/NavButton.vue';

import {mount} from "@vue/test-utils";

describe("CountrySearch.vue", () => {
  it("Si se es usuario se cargan los botones para su rol.", () => {
    const wrapper = mount(Header, {
      data: () => ({
        navButtons: [
          {id: 1, label: "History", href:"/history", forRole:"user" }, // 1
          {id: 2, label: "Sign in", href:"/login", forRole:"none" },
          {id: 3, label: "Home", href:"/", forRole:"all" }, // 2
          {id: 4, label: "Bookmarks", href:"/bookmarks", forRole:"user" }, // 3
          {id: 5, label: "Sign up", href:"/register", forRole:"none" },
          {id: 6, label: "Sign out", href:"/logout", forRole:"user" }, // 4
          {id: 7, label: "Sign out", href:"/logout", forRole:"admin" },
          {id: 8, label: "Admin", href:"/admin", forRole:"admin" },
        ],
      }),
      propsData: {
        userRole: "user"
      }
    });
    expect(wrapper.findAll('[data-test="navButton"]').length).toBe(4)
  });

  it("Si se es administrador se cargan los botones para su rol.", () => {
    const wrapper = mount(Header, {
      data: () => ({
        navButtons: [
          {id: 1, label: "History", href:"/history", forRole:"user" }, 
          {id: 2, label: "Sign in", href:"/login", forRole:"none" },
          {id: 3, label: "Home", href:"/", forRole:"all" }, // 1
          {id: 4, label: "Bookmarks", href:"/bookmarks", forRole:"user" }, 
          {id: 5, label: "Sign up", href:"/register", forRole:"none" },
          {id: 6, label: "Sign out", href:"/logout", forRole:"user" },
          {id: 7, label: "Sign out", href:"/logout", forRole:"admin" }, // 2
          {id: 8, label: "Admin", href:"/admin", forRole:"admin" }, // 3
        ],
      }),
      propsData: {
        userRole: "admin"
      }
    });
    expect(wrapper.findAll('[data-test="navButton"]').length).toBe(3)
  });

    it("Si se es un usuario no registrado se cargan los botones para su rol.", () => {
    const wrapper = mount(Header, {
      data: () => ({
        navButtons: [
          {id: 1, label: "History", href:"/history", forRole:"user" }, 
          {id: 2, label: "Sign in", href:"/login", forRole:"none" }, // 1
          {id: 3, label: "Home", href:"/", forRole:"all" },  // 2
          {id: 4, label: "Bookmarks", href:"/bookmarks", forRole:"user" }, 
          {id: 5, label: "Sign up", href:"/register", forRole:"none" }, // 3
          {id: 6, label: "Sign out", href:"/logout", forRole:"user" },
          {id: 7, label: "Sign out", href:"/logout", forRole:"admin" }, 
          {id: 8, label: "Admin", href:"/admin", forRole:"admin" }, 
          {id: 9, label: "OtroMas", href:"/otro", forRole:"none" }, // 4
          {id: 19, label: "OtroMas2", href:"/otro2", forRole:"none" }, // 5
        ],
      }),
      propsData: {
        userRole: "none"
      }
    });
    expect(wrapper.findAll('[data-test="navButton"]').length).toBe(5)
  });
})

