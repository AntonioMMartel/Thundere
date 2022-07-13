import Home from '../vue/views/Home.vue';
import {mount} from "@vue/test-utils";

describe("Home.vue", () => {
  it("renders", () => {
    const wrapper = mount(Home);
    expect(wrapper.text()).toContain("Thunre")
  })
})
