import Register from '../../vue/views/Registration.vue';
import {mount, shallowMount} from "@vue/test-utils";

import FadingLightsAnimation from '../../vue/components/FadingLightsAnimation.vue';


describe("Register.vue", () => {
  it("Carga la animación", async () => {
    const wrapper = shallowMount(Register);
    expect(wrapper.findComponent(FadingLightsAnimation).exists()).toBe(true)
  });

  it("Aparece texto de registro", async () => {
    const wrapper = mount(Register);
    const title = wrapper.get('[data-test="title"]')
    expect(title.text()).toBe("Make an account")
  });

  it("Aparecen cuatro inputs para añadir los datos", async () => {
    const wrapper = mount(Register);
    expect(wrapper.findAll('[data-test="input"]').length).toBe(4)
  });

  it("Aparecen todos los labels de los inputs", async () => {
    const wrapper = mount(Register);
    const email = wrapper.get('[data-test="email"]')
    const username = wrapper.get('[data-test="username"]')
    const password = wrapper.get('[data-test="password"]')
    const passwordRepeat = wrapper.get('[data-test="passwordRepeat"]')

    expect(email.text()).toBe("Email:")
    expect(username.text()).toBe("Username:")
    expect(password.text()).toBe("Password:")
    expect(passwordRepeat.text()).toBe("Repeat your password:")
  });


  /* jsdom no soporta navegación
  it("Se redirige a la vista Login si el registro es exitoso", async () => {
    const wrapper = mount(Register);
    const submit = wrapper.get('[data-test="submit"]')
    await wrapper.get('[id="username"]').setValue("Prueba")
    await wrapper.get('[id="email"]').setValue("Prueba@email.com")
    await wrapper.get('[id="password"]').setValue("123qwe")
    await wrapper.get('[id="password-repeat"]').setValue("123qwe")

    await submit.trigger('click')

    expect(window.location.href).toBe(window.location.href + "login")
  });
  */
})

