import CountrySearchInput from '../../vue/components/CountrySearchInput.vue';
import {mount, shallowMount} from "@vue/test-utils";

describe("CountrySearch.vue", () => {
  it("Carga el texto de error", () => {
    const wrapper = mount(CountrySearchInput, {
      data() {
        return {
          error: true,
          errorMessage: "Ha habido un error inesperado",
          textRows: 1,
        };
      },
    });
    const error = wrapper.get('[data-test="error"]')
    expect(error.text()).toBe("Ha habido un error inesperado")
  });

  it("Si no hay error no hay mensaje de error", () => {
    const wrapper = mount(CountrySearchInput);
    expect(wrapper.find('[data-test="error"]').exists()).toBe(false)
  });

  it("Carga el área de búsqueda", async () => {
    const wrapper = mount(CountrySearchInput);
    expect(wrapper.find('[data-test="textArea"]').exists()).toBe(true)
  });
})

