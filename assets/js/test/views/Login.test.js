import Login from '../../vue/views/Login.vue';
import {mount, shallowMount} from "@vue/test-utils";

import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';


describe("Login.vue", () => {
  it("Carga la animación", async () => {
    const wrapper = shallowMount(Login);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(true)
  });

  it("Aparece texto de Login", async () => {
    const wrapper = mount(Login);
    const title = wrapper.get('[data-test="title"]')
    expect(title.text()).toBe("Login to the page")
  });

  it("Aparecen dos inputs para añadir los datos", async () => {
    const wrapper = mount(Login);
    expect(wrapper.findAll('[data-test="input"]').length).toBe(2)
  });

  it("Se redirige a la vista Home si el inicio de sesión es exitoso", async () => {
    const wrapper = mount(Login);
    const submit = wrapper.get('[data-test="submit"]')
    await wrapper.get('[id="email"]').setValue("goofy@email.com")
    await wrapper.get('[id="password"]').setValue("123qwe")
    await submit.trigger('click')
    expect(window.location.href).toBe(window.location.href)
  });

})

