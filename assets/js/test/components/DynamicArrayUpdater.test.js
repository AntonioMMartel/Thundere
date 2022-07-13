import DynamicArrayUpdater from '../../vue/components/DynamicArrayUpdater.vue';
import {mount, shallowMount} from "@vue/test-utils";


describe("Home.vue", () => {
  it("Se activa el menu de opciones extendido al hacer hover sobre el componente", () => {
    const wrapper = mount(DynamicArrayUpdater, {
      data() {
        return {
          pointer: 0,
          showingOptionsMenu: true,
          menuBeingHovered: false,
          addingNewElement: false
        };
      },
      propsData: {
        array: ["1","2","3"],
      }
    });
    const indexInput = wrapper.get('[data-test="indexInput"]')
    const addElementButton = wrapper.get('[data-test="addElementButton"]')

    expect(indexInput.exists()).toBe(true)
    expect(addElementButton.exists()).toBe(true)
  });

  it("Si no se hace hover el menu extendido no se abre", () => {
    const wrapper = mount(DynamicArrayUpdater,{
      data() {
        return {
          pointer: 0,
          showingOptionsMenu: false,
          menuBeingHovered: false,
          addingNewElement: false
        };
      },
      propsData: {
        array: ["1","2","3"],
      }
  });

    expect(wrapper.find('[data-test="indexInput"]').exists()).toBe(false)
    expect(wrapper.find('[data-test="addElementButton"]').exists()).toBe(false)
  });

  it("Se carga el menú de opciones básico", () => {
    const wrapper = mount(DynamicArrayUpdater,{
    data() {
      return {
        pointer: 0,
        showingOptionsMenu: false,
        menuBeingHovered: false,
        addingNewElement: false
      };
    },
      propsData: {
        array: ["1","2","3"],
      }
    });

    expect(wrapper.find('[data-test="optionsMenu"]').exists()).toBe(true)
  })

   it("Muestra por defecto el primer valor del array correctamente", () => {
    const wrapper = mount(DynamicArrayUpdater,{
    data() {
      return {
        pointer: 0,
        showingOptionsMenu: false,
        menuBeingHovered: false,
        addingNewElement: false
      };
    },
      propsData: {
        array: ["1","2","3"],
      }
    });
    const dataValue = wrapper.get('[data-test="dataValue"]')
    expect(dataValue.text()).toBe("1")
  })

  it("Cambiar el puntero cambia exitosamente el valor representado", () => {
    const wrapper = mount(DynamicArrayUpdater,{
    data() {
      return {
        pointer: 1,
        showingOptionsMenu: false,
        menuBeingHovered: false,
        addingNewElement: false
      };
    },
      propsData: {
        array: ["1","2","3"],
      }
    });
    const dataValue = wrapper.get('[data-test="dataValue"]')
    expect(dataValue.text()).toBe("2")
  })
  it("Cuando se está añadiendo un dato no aparece el valor de ese indice, sino un texto que avisa de que se está añadiendo", () => {
    const wrapper = mount(DynamicArrayUpdater,{
    data() {
      return {
        pointer: 1,
        showingOptionsMenu: false,
        menuBeingHovered: false,
        addingNewElement: true
      };
    },
      propsData: {
        array: ["1","2","3"],
      }
    });
    expect(wrapper.find('[data-test="dataValue"]').exists()).toBe(false)
    expect(wrapper.find('[data-test="addingNewElement"]').exists()).toBe(true)
  })

  it("El texto de añadir dato se muestra correctamente", () => {
    const wrapper = mount(DynamicArrayUpdater,{
    data() {
      return {
        pointer: 1,
        showingOptionsMenu: false,
        menuBeingHovered: false,
        addingNewElement: true
      };
    },
      propsData: {
        array: ["1","2","3"],
      }
    });
    expect(wrapper.find('[data-test="addingNewElement"]').text()).toBe("Adding new element")
  })
})

