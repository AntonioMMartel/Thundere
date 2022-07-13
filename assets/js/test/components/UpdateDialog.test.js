import UpdateDialog from '../../vue/components/UpdateDialog.vue';
import {mount, shallowMount} from "@vue/test-utils";

describe("UpdateDialog.vue", () => {

  it("Aparece texto de la acción de registrar cuando se está registrando", async () => {
    const wrapper = mount(UpdateDialog, {
      propsData: {
        "data": {}, 
        "target": "Countries", 
        "id": 1111, 
        "dialogIsUpdating": true, 
        "message": "", 
        "mode": ""
      }
    });
    const title = wrapper.get('[data-test="editingTitle"]')
    expect(title.text()).toBe("Editing Countries")
  });

  it("Aparece texto de la acción de añadir cuando se está añadiendo", async () => {
    const wrapper = mount(UpdateDialog, {
      propsData: {
        "data": {}, 
        "target": "Countries", 
        "id": 1111, 
        "dialogIsUpdating": false, 
        "message": "", 
        "mode": ""
      }
    });
    const title = wrapper.get('[data-test="addingTitle"]')
    expect(title.text()).toBe("Adding Countries")
  });
  it("Aparece el mensaje pasado por parámetro cuando este existe", async () => {
    const wrapper = mount(UpdateDialog, {
      propsData: {
        "data": {}, 
        "target": "Countries", 
        "id": 1111, 
        "dialogIsUpdating": false, 
        "message": "Mensaje", 
        "mode": ""
      }
    });
    const messageText = wrapper.get('[data-test="messageText"]')
    expect(messageText.text()).toBe("Mensaje")
  });
  it("Aparece botón de añadir cuando se está añadiendo", async () => {
    const wrapper = mount(UpdateDialog, {
      propsData: {
        "data": {}, 
        "target": "Countries", 
        "id": 1111, 
        "dialogIsUpdating": false, 
        "message": "", 
        "mode": ""
      }
    });
        expect(wrapper.find('[data-test="addButton"]').exists()).toBe(true)

  });

  it("Aparece botón de actualizar cuando se está actualizando", async () => {
    const wrapper = mount(UpdateDialog, {
      propsData: {
        "data": {}, 
        "target": "Countries", 
        "id": 1111, 
        "dialogIsUpdating": true, 
        "message": "", 
        "mode": ""
      }
    });
    expect(wrapper.find('[data-test="updateButton"]').exists()).toBe(true)
  });

})

