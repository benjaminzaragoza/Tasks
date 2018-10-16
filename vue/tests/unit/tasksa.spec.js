import { expect } from 'chai'
import { shallowMount, mount } from '@vue/test-utils'
import tasks from '../../../resources/js/components/Tasks.vue'
import moxios from 'moxios'

describe('tasks.vue', () => {
  // prepare
  beforeEach(function () {
    // import and pass your custom axios instance to this method
    moxios.install(global.axios)
  })

  afterEach(function () {
    // import and pass your custom axios instance to this method
    moxios.uninstall(global.axios)
  })

  it('contains_a_list_of_tasks', () => {
    // execute
    const wrapper = mount(tasks, {
      propsData: {
        tasks: [{
          id: 1,
          name: 'comprar pa',
          completed: false
        },
        {
          id: 2,
          name: 'comprar llet',
          completed: true

        },
        {
          id: 3,
          name: 'estudiar php',
          completed: false
        }
        ]
      }
    })
    // console.log('aqui_text')
    // console.log(wrapper.text())
    //
    // console.log('html')
    // console.log(wrapper.html)
    // expect
    expect(wrapper.text()).contains('comprar pa')
    expect(wrapper.text()).contains('comprar llet')
    expect(wrapper.text()).contains('estudiar php')

    // wrapper vm -> Objecte vue
    expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
    expect(wrapper.vm.dataTasks[0].id).equals(1)
    expect(wrapper.vm.dataTasks[0].name).equals('comprar pa')
    expect(wrapper.vm.dataTasks[0].completed).equals(false)

    expect(wrapper.vm.dataTasks[1].id).equals(2)
    expect(wrapper.vm.dataTasks[1].name).equals('comprar llet')
    expect(wrapper.vm.dataTasks[1].completed).equals(true)

    expect(wrapper.vm.dataTasks[2].id).equals(3)
    expect(wrapper.vm.dataTasks[2].name).equals('estudiar php')
    expect(wrapper.vm.dataTasks[2].completed).equals(false)
  })

  it.only('contains_a_list_of_tasks_from_api_if_no_prop_tasks_is_provided', (done) => {
    // 1
    moxios.stubRequest('/api/v1/tasks', {
      status: 200,
      response: [
        {
          id: 1,
          name: 'comprar pa',
          completed: false
        },
        {
          id: 2,
          name: 'comprar llet',
          completed: true

        },
        {
          id: 3,
          name: 'estudiar php',
          completed: false
        }
      ]

    // 2
    moxios.wait(())// <tasks></tasks>
    expect(wrapper.text()).contains('comprar pa')
    expect(wrapper.text()).contains('comprar llet')
    expect(wrapper.text()).contains('estudiar php')

    // wrapper vm -> Objecte vue
    expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
    expect(wrapper.vm.dataTasks[0].id).equals(1)
    expect(wrapper.vm.dataTasks[0].name).equals('comprar pa')
    expect(wrapper.vm.dataTasks[0].completed).equals(false)

    expect(wrapper.vm.dataTasks[1].id).equals(2)
    expect(wrapper.vm.dataTasks[1].name).equals('comprar llet')
    expect(wrapper.vm.dataTasks[1].completed).equals(true)

    expect(wrapper.vm.dataTasks[2].id).equals(3)
    expect(wrapper.vm.dataTasks[2].name).equals('estudiar php')
    expect(wrapper.vm.dataTasks[2].completed).equals(false)

    done()
  })
    // 3
    // expect(wrapper,text())
  })
  // it.skip('todo2 ', () => {
  // })
})
