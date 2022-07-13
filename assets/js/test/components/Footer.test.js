import Footer from '../../vue/components/Footer.vue';
import {mount, shallowMount} from "@vue/test-utils";

describe("Footer.vue", () => {
  it("Se carga el texto del pie de página", () => {
    const wrapper = mount(Footer);
    expect(wrapper.text()).toBe("©2021 Gofio SA ™ - Todos los derechos reservados")
  });
})

