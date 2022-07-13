import Logout from '../../vue/views/Logout.vue';
import {mount, shallowMount} from "@vue/test-utils";

import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';


describe("Logout.vue", () => {
  it("No carga la animación", async () => {
    const wrapper = shallowMount(Logout);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(false)
  });

  it("Carga el texto de espera", async () => {
    const wrapper = mount(Logout);
    expect(wrapper.text()).toMatch("Iconito / Gif crema de cargando")
  });

})

