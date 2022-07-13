import Home from '../../vue/views/Home.vue';
import {mount, shallowMount} from "@vue/test-utils";

import FiltersMenu from '../../vue/components/FiltersMenu.vue';
import CountrySearchInput from '../../vue/components/CountrySearchInput.vue';
import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';


describe("Home.vue", () => {
  it("Carga el título de la aplicación", () => {
    const wrapper = mount(Home);

    const title = wrapper.get('[data-test="title"]')

    expect(title.text()).toBe("Thundere")
  });

  it("Carga el menú de filtros", () => {
    const wrapper = shallowMount(Home);
    expect(wrapper.findComponent(FiltersMenu).exists()).toBe(true)
  });

  it("Carga el buscador de países", async () => {
    const wrapper = shallowMount(Home);
    expect(wrapper.findComponent(CountrySearchInput).exists()).toBe(true)
  });

  it("Carga la animación", async () => {
    const wrapper = shallowMount(Home);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(true)
  });
})

