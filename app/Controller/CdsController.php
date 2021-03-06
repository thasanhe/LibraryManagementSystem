<?php
App::uses('AppController', 'Controller');
/**
 * Cds Controller
 *
 * @property Cd $Cd
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CdsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cd->recursive = 0;
		$this->set('cds', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cd->exists($id)) {
			throw new NotFoundException(__('Invalid cd'));
		}
		$options = array('conditions' => array('Cd.' . $this->Cd->primaryKey => $id));
		$this->set('cd', $this->Cd->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cd->create();
			if ($this->Cd->save($this->request->data)) {
				$this->Session->setFlash(__('The cd has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cd could not be saved. Please, try again.'));
			}
		}
		$ceDetails = $this->Cd->CeDetail->find('list');
		$this->set(compact('ceDetails'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cd->exists($id)) {
			throw new NotFoundException(__('Invalid cd'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cd->save($this->request->data)) {
				$this->Session->setFlash(__('The cd has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cd could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cd.' . $this->Cd->primaryKey => $id));
			$this->request->data = $this->Cd->find('first', $options);
		}
		$ceDetails = $this->Cd->CeDetail->find('list');
		$this->set(compact('ceDetails'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cd->id = $id;
		if (!$this->Cd->exists()) {
			throw new NotFoundException(__('Invalid cd'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cd->delete()) {
			$this->Session->setFlash(__('The cd has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cd could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
