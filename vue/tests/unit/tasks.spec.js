import { expect } from 'chai'
import { mount } from '@vue/test-utils'
import Tasks from '../../../resources/js/components/Tasks.vue'
import moxios from 'moxios'

describe('Tasks.vue', () => {
  beforeEach(function () {
    moxios.install(global.axios)
  })

  afterEach(function () {
    moxios.uninstall(global.axios)
  })

  it('contains_a_list_of_tasks', () => {
    // 1 PREPARE (OPTIONAL)

    // 2 EXECUTE
    const wrapper = mount(Tasks, {
      propsData: {
        tasks: [
          {
            id: 1,
            name: 'Comprar pa',
            completed: false
          },
          {
            id: 2,
            name: 'Comprar llet',
            completed: true
          },
          {
            id: 3,
            name: 'Estudiar PHP',
            completed: false
          }
        ]
      }
    }) // <tasks tasks="[{},{},{}]"></tasks>

    // console.log('AQUI TEXT:')
    // console.log(wrapper.text())
    // console.log('AQUI HTML:')
    // console.log(wrapper.html())
    // 3 EXPECT
    expect(wrapper.text()).contains('Comprar pa')
    expect(wrapper.text()).contains('Comprar llet')
    expect(wrapper.text()).contains('Estudiar PHP')

    // wrapper.vm -> Objecte Vue (vm: View Model)
    expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
    expect(wrapper.vm.dataTasks[0].id).equals(1)
    expect(wrapper.vm.dataTasks[0].name).equals('Comprar pa')
    expect(wrapper.vm.dataTasks[0].completed).equals(false)

    expect(wrapper.vm.dataTasks[1].id).equals(2)
    expect(wrapper.vm.dataTasks[1].name).equals('Comprar llet')
    expect(wrapper.vm.dataTasks[1].completed).equals(true)

    expect(wrapper.vm.dataTasks[2].id).equals(3)
    expect(wrapper.vm.dataTasks[2].name).equals('Estudiar PHP')
    expect(wrapper.vm.dataTasks[2].completed).equals(false)
  })
  it.skip('shows_error_when_api_fails', (done) => {
    moxios.stubRequest('/api/v1/tasks', {
      status: 500,
      response: {
        data: 'ha petat'
      }
    })

    const wrapper = mount(Tasks) // <tasks></tasks>
    expect(wrapper.text()).contains('ha petat')
  })
  it.only('shows_error', () => {
    // 1
    // 2
    const wrapper = mount(Tasks) // <tasks></tasks>
    wrapper.vm.errorMessage = 'ui que mal'
    // 3
    expect(wrapper.text().contains('ui que mal'))
  })

  it.only('not_show_filters_when_no_tasks', () => {
    // 1
    // 2
    const wrapper = mount(Tasks) // <tasks></tasks>
    wrapper.vm.errorMessage = 'ui que mal'
    // 3
    expect(wrapper.text().contains('Filtros:'))
  })

  it('contains_a_list_of_tasks_from_api_if_no_prop_tasks_is_provided', (done) => {
    // 1 Prepare (opcional)
    moxios.stubRequest('/api/v1/tasks', {
      status: 200,
      response: [
        {
          id: 1,
          name: 'Comprar pa',
          completed: false
        },
        {
          id: 2,
          name: 'Comprar llet',
          completed: true
        },
        {
          id: 3,
          name: 'Estudiar PHP',
          completed: false
        }
      ]
    })

    // 2 Execució
    const wrapper = mount(Tasks) // <tasks></tasks>

    console.log(wrapper.html())
    // 3 expectations
    moxios.wait(() => {
      expect(wrapper.text()).contains('Comprar pa')
      expect(wrapper.text()).contains('Comprar llet')
      expect(wrapper.text()).contains('Estudiar PHP')

      // console.log('htmle del compnent es')
      // console.log(wrapper.html())
      // console.log(wrapper.find('span#task2').classes())
      // eslint-disable-next-line no-unused-expressions
      expect(wrapper.find('span#task2').classes('strike')).to.be.true
      // Class selectors -> spntasks2
      done()
      // // wrapper.vm -> Objecte Vue (vm: View Model)
      // expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
      // expect(wrapper.vm.dataTasks[0].id).equals(1)
      // expect(wrapper.vm.dataTasks[0].name).equals('Comprar pa')
      // expect(wrapper.vm.dataTasks[0].completed).equals(false)
      //
      // expect(wrapper.vm.dataTasks[1].id).equals(2)
      // expect(wrapper.vm.dataTasks[1].name).equals('Comprar llet')
      // expect(wrapper.vm.dataTasks[1].completed).equals(true)
      //
      // expect(wrapper.vm.dataTasks[2].id).equals(3)
      // expect(wrapper.vm.dataTasks[2].name).equals('Estudiar PHP')
      // expect(wrapper.vm.dataTasks[2].completed).equals(false)
    })
  })
})
