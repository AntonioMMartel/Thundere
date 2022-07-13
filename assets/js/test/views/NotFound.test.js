import NotFound from '../../vue/views/NotFound.vue';
import {mount, shallowMount} from "@vue/test-utils";

import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';


describe("NotFound.vue", () => {
  it("Carga la animación", () => {
    const wrapper = shallowMount(NotFound);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(true)
  });

  it("Carga el título", () => {
    const wrapper = mount(NotFound);

    const title = wrapper.get('[data-test="title"]')

    expect(title.text()).toMatch("Page not found")
  });
  
  it("Carga el testo", () => {
    const wrapper = mount(NotFound);

    const text = wrapper.get('[data-test="text"]')

    expect(text.text()).toMatch("The page you were looking for doesn't exist.")
  });

})

