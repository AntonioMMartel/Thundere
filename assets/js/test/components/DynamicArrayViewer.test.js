import DynamicArrayViewer from '../../vue/components/DynamicArrayViewer.vue';
import {mount} from "@vue/test-utils";

describe("DynamicArrayViewer.vue", () => {
  it("Carga el primer valor del vector por defecto", () => {
    const wrapper = mount(DynamicArrayViewer, {
      propsData: {
        array: ["1","2","3"],
      }
    });
    const dataValue = wrapper.get('[data-test="dataValue"]')
    expect(dataValue.text()).toBe("1")
  });
  it("Carga correctamente el valor del índice al que se apunta al cambiar el puntero", () => {
    const wrapper = mount(DynamicArrayViewer, {
      data() {
        return {
          pointer: 1,
        };
      },
      propsData: {
        array: ["1","2","3"],
      }
    });
    const dataValue = wrapper.get('[data-test="dataValue"]')
    expect(dataValue.text()).toBe("2")
  });

})

