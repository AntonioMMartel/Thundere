import CountrySearchInput from '../../vue/components/CountrySearchInput.vue';
import {mount, shallowMount} from "@vue/test-utils";


describe("Home.vue", () => {
  it("Carga el título de la aplicación", () => {
    const wrapper = mount(Home);

    const title = wrapper.get('[data-test="title"]')

    expect(title.text()).toBe("Thundere")
  });

})

