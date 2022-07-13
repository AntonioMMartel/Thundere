import Admin from '../../vue/views/Admin.vue';
import {mount, shallowMount} from "@vue/test-utils";
import '@testing-library/jest-dom';

import UpdateDialog from '../../vue/components/UpdateDialog.vue';
import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';



describe("Admin.vue", () => {

  it("Carga la animación", async () => {
    const wrapper = shallowMount(Admin);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(true)
  });
  
  it("Muestra en la vista el primer valor de los targets", () => {
    const wrapper = mount(Admin, {
      data() {
        return {
          targets: ["1", "2", "3"],
          targetSelector: 0,
          data: { Countries: [], Users: [] },
          message: "Loading data...",
          page: 0,
          maxElements: 5,
          openDialogData: {},
          dialogIsOpen: false,
          selectedId: 0,
          dialogIsUpdating: false,
          dialogMessage: "",
          dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
          selectedDialogMode: 0
        }
      }
    });
    const target = wrapper.get('[data-test="selectedTarget"]')
    expect(target.text()).toBe("1")
  });
  it("Cambia correctamente el texto que define el tipo de datos seleccionado al pulsar el botón izquierdo", async () => {
    const wrapper = mount(Admin, {
      data() {
        return {
          targets: ["1", "2", "3"],
          targetSelector: 0,
          data: { Countries: [], Users: [] },
          message: "Loading data...",
          page: 0,
          maxElements: 5,
          openDialogData: {},
          dialogIsOpen: false,
          selectedId: 0,
          dialogIsUpdating: false,
          dialogMessage: "",
          dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
          selectedDialogMode: 0
        }
      }
    });
    const leftArrow = wrapper.get('[data-test="moveTargetBackwards"]')
    const target = wrapper.get('[data-test="selectedTarget"]')
    await leftArrow.trigger('click')

    expect(target.text()).toBe("3")
  });
  it("Cambia correctamente el texto que define el tipo de datos seleccionado al pulsar el botón derecho", async () => {
    const wrapper = mount(Admin, {
      data() {
        return {
          targets: ["1", "2", "3"],
          targetSelector: 0,
          data: { Countries: [], Users: [] },
          message: "Loading data...",
          page: 0,
          maxElements: 5,
          openDialogData: {},
          dialogIsOpen: false,
          selectedId: 0,
          dialogIsUpdating: false,
          dialogMessage: "",
          dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
          selectedDialogMode: 0
        }
      }
    });
    const rightArrow = wrapper.get('[data-test="moveTargetForwards"]')
    const target = wrapper.get('[data-test="selectedTarget"]')

    await rightArrow.trigger('click')
    expect(target.text()).toBe("2")
  });
  it("Cambia correctamente el texto que define el tipo de datos seleccionado al pulsar el botón derecho", async () => {
    const wrapper = mount(Admin, {
      data() {
        return {
          targets: ["1", "2", "3"],
          targetSelector: 0,
          data: { Countries: [], Users: [] },
          message: "Loading data...",
          page: 0,
          maxElements: 5,
          openDialogData: {},
          dialogIsOpen: false,
          selectedId: 0,
          dialogIsUpdating: false,
          dialogMessage: "",
          dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
          selectedDialogMode: 0
        }
      }
    });
    const rightArrow = wrapper.get('[data-test="moveTargetForwards"]')
    const target = wrapper.get('[data-test="selectedTarget"]')

    await rightArrow.trigger('click')
    expect(target.text()).toBe("2")
  });
  it("Carga por defecto la tabla de países", async () => {
    const wrapper = mount(Admin);
    const countriesTable = wrapper.get('[data-test="countriesTable"]')

    expect(countriesTable.exists()).toBe(true)

  });

  it("Cambia correctamente de tabla al cambiar el target", async () => {
    const wrapper = mount(Admin);
    const rightArrow = wrapper.get('[data-test="moveTargetForwards"]')
    await rightArrow.trigger('click')
    expect(wrapper.findAll('[data-test="usersTable"]').length).toBe(1)
  });

  it("Se manda la señal de abrir el diálogo al pulsar botón de añadir", async () => {
    const wrapper = mount(Admin);
    const addButton = wrapper.get('[data-test="addButton"]')
    await addButton.trigger('click')
    expect(wrapper.findComponent(UpdateDialog).exists()).toBe(true)
  })


  it("Carga el diálogo de añadir o modificar al pulsar el botón de modificar", async () => {
    const wrapper = mount(Admin, {
      data() {
        return {
          targets: ["1", "2", "3"],
          targetSelector: 0,
          data: { Countries: [], Users: [] },
          message: "Loading data...",
          page: 0,
          maxElements: 5,
          openDialogData: {},
          dialogIsOpen: true,
          selectedId: 0,
          dialogIsUpdating: false,
          dialogMessage: "",
          dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
          selectedDialogMode: 0
        }
      }
    });
    expect(wrapper.findComponent(UpdateDialog).exists()).toBe(true)
  });

})

