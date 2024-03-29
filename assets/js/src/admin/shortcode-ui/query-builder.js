/**
 * @module Product Query Builder
 * @description Using the links list, and direct text entry, add query vars to the search field.
 */

import _ from 'lodash';
import delegate from 'delegate';
import Choices from 'choices.js';
import * as tools from '../../utils/tools';
import * as slide from '../../utils/dom/slide';
import { setAccActiveAttributes, setAccInactiveAttributes } from '../../utils/dom/accessibility';
import shortcodeState from '../config/shortcode-state';
import { on, trigger } from '../../utils/events';

const el = {};

/**
 * @function openChildMenu
 * @description Toggle the accordion open
 */
const openChildMenu = (header, content) => {
	tools.addClass(header.parentNode, 'active');
	setAccActiveAttributes(header, content);
	slide.down(content, 150);
};

/**
 * @function closeChildMenu
 * @description Toggle the accordion closed
 */
const closeChildMenu = (header, content) => {
	tools.removeClass(header.parentNode, 'active');
	setAccInactiveAttributes(header, content);
	slide.up(content, 150);
};

/**
 * @function toggleChildMenu
 * @description Toggle child menu lists.
 * @param e event
 */
const toggleChildMenu = (e) => {
	const header = e.delegateTarget;
	const content = header.nextElementSibling;

	if (tools.hasClass(header.parentNode, 'active')) {
		closeChildMenu(header, content);
	} else {
		openChildMenu(header, content);
	}
};

/**
 * @function buildQueryObject
 * @description add new values to the wpAPIQueryObj
 * @param key string
 * @param value string
 */
const buildQueryObject = (key = '', value) => {
	if (!key) {
		shortcodeState.wpAPIQueryObj.search.push(value);
		return;
	}

	shortcodeState.wpAPIQueryObj[key].push(value);
};

/**
 * @function reduceQueryObject
 * @description remove existing values from the wpAPIQueryObj
 * @param key string
 * @param value string
 */
const reduceQueryObject = (key, value) => {
	let valIndex = '';

	if (!key) {
		valIndex = shortcodeState.wpAPIQueryObj.search.indexOf(value);
		shortcodeState.wpAPIQueryObj.search.splice(valIndex, 1);
		return;
	}

	valIndex = shortcodeState.wpAPIQueryObj[key].indexOf(value);
	shortcodeState.wpAPIQueryObj[key].splice(valIndex, 1);
};

/**
 * @function addChoice
 * @description add a choice to the search query.
 */
const addChoice = (value, label) => {
	el.searchInput.setValue([
		{
			value,
			label,
		},
	]);

	trigger({ event: 'bigcommerce/shortcode_query_term_added', data: { value, label }, native: false });
};

/**
 * @function removeChoice
 * @description remove a choice from the search query.
 */
const removeChoice = (value) => {
	el.searchInput.removeItemsByValue(value);
	trigger({ event: 'bigcommerce/shortcode_query_term_removed', data: { value }, native: false });
};

/**
 * @function handleChoiceAddition
 * @description run special functionality based on addItem event in Choices.js
 * @param e event object created by addItem
 */
const handleChoiceAddition = (e) => {
	if (e.detail.value === e.detail.label) {
		buildQueryObject('', e.detail.value);
		trigger({ event: 'bigcommerce/shortcode_query_term_added', data: { value: e.detail.value, label: e.detail.label }, native: false });
	}
};

/**
 * @function handleChoiceRemoval
 * @description run special functionality based on removeItem event in Choices.js
 * @param e event object created by removeItem
 */
const handleChoiceRemoval = (e) => {
	const value = e.detail.value;
	const link = tools.getNodes(`[data-value="${value}"]`, false, el.linkList, true)[0];
	trigger({ event: 'bigcommerce/shortcode_query_term_removed', data: { value }, native: false });

	if (e.detail.fromSettings) {
		removeChoice(value);
	}

	if (!link) {
		reduceQueryObject('', value);
		return;
	}

	if (link && link.classList.contains('bcqb-item-selected')) {
		const key = link.dataset.key;

		link.classList.remove('bcqb-item-selected');
		reduceQueryObject(key, value);
	}
};

/**
 * @function handleLinks
 * @description Handle the link click event and add/remove items from the search query.
 * @param e event
 */
const handleLinks = (e) => {
	const key = e.delegateTarget.dataset.key;
	const value = e.delegateTarget.dataset.value;
	const label = e.delegateTarget.text;

	e.delegateTarget.classList.toggle('bcqb-item-selected');

	if (e.delegateTarget.classList.contains('bcqb-item-selected')) {
		addChoice(value, label);
		buildQueryObject(key, value);
		e.delegateTarget.setAttribute('aria-selected', 'true');
		return;
	}

	e.delegateTarget.setAttribute('aria-selected', 'false');
	removeChoice(value);
	reduceQueryObject(key, value);
};

/**
 * @function clearSearch
 * @description clear all choices from the search input and reset links and objects.
 */
const clearSearch = () => {
	el.searchInput.clearStore();
	shortcodeState.wpAPIQueryObj = {
		bigcommerce_flag: [],
		bigcommerce_brand: [],
		bigcommerce_category: [],
		recent: [],
		search: [],
	};

	el.linkList.querySelectorAll('.bcqb-item-selected').forEach((link) => {
		link.classList.remove('bcqb-item-selected');
	});
};

/**
 * @function addSavedUICustomChoices
 * @description Add custom search/query terms to the search field before running the query.
 * @param choices
 */
const addSavedUICustomChoices = (choices) => {
	choices.forEach(choice => addChoice(choice, choice));
};

/**
 * @function initLinkListClicks
 * @description If a saved term exists, fire a click event on that item to add it to the search bar and state object.
 * @param terms
 * TODO: @vinny This needs to be removed and replaced with new logic in handleLinks that allows for events AND state changes.
 */
const initLinkListClicks = (terms) => {
	if (!terms) {
		return;
	}

	terms.forEach((slug) => {
		const listLink = tools.getNodes(`[data-slug="${slug}"]`, false, el.linkList, true)[0];
		const listParent = tools.closest(listLink, '[data-js="bcqb-parent-list-item"]:not(.active)');

		listLink.click();

		if (slug[0] && listParent) {
			_.delay(() => tools.getNodes('bcqb-has-child-list', false, listParent)[0].click(), 100);
		}
	});
};

/**
 * @function setShortcodeState
 * @description When the UI dialog is triggered, reset the UI and, if applicable, populate it with saved state data.
 * @param event
 */
const setShortcodeState = (event) => {
	clearSearch();

	const currentBlockParams = event.detail.params;

	if (!currentBlockParams || currentBlockParams.length <= 0) {
		return;
	}

	Object.entries(currentBlockParams).forEach(([key, value]) => {
		// TODO: Maybe change this to a switch function?
		if (key === 'brand' || key === 'category') {
			const termIDs = [...value.split(',')];

			initLinkListClicks(termIDs);
		}

		if (key === 'search') {
			addSavedUICustomChoices([...value.split(',')]);
		}

		if (key === 'featured' || key === 'sale' || key === 'recent') {
			initLinkListClicks([key]);
		}
	});

	_.delay(() => trigger({ event: 'bigcommerce/shortcode_ui_state_ready', native: false }), 100);
};

const cacheElements = () => {
	el.dialog = tools.getNodes('bc-shortcode-ui-products', false, document, false)[0];
	el.linkList = tools.getNodes('bcqb-list')[0];
	el.searchForm = tools.getNodes('bc-shortcode-ui-search', false, el.dialog, false)[0];
};

const bindEvents = () => {
	el.searchInput = new Choices('.bc-shortcode-ui__search-input', {
		removeItemButton: true,
		duplicateItems: false,
	});

	delegate(el.linkList, '[data-js="bcqb-has-child-list"]', 'click', toggleChildMenu);
	delegate(el.linkList, '.bc-shortcode-ui__query-builder-anchor', 'click', handleLinks);
	el.searchInput.passedElement.addEventListener('removeItem', handleChoiceRemoval);
	el.searchInput.passedElement.addEventListener('addItem', handleChoiceAddition);
	delegate('[data-js="bcqb-clear"]', 'click', clearSearch);
	on(document, 'bigcommerce/set_shortcode_ui_state', setShortcodeState);
	on(document, 'bigcommerce/remove_query_term', handleChoiceRemoval);
};

const init = () => {
	cacheElements();
	bindEvents();
};

export default init;
