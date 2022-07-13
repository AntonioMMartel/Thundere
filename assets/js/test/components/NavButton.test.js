import NavButton from '../../vue/components/NavButton.vue';
import {mount} from "@vue/test-utils";

describe("NavButton.vue", () => {
  it("El botoón carga el texto que tiene que mostrar", () => {
    const wrapper = mount(NavButton, {
      propsData: {
        label: "Texto",
        href: "/test"
      }
    });
    expect(wrapper.get('[data-test="button"]').text()).toBe("Texto")
  });
})

