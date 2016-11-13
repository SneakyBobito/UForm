---
currentMenu: rendering
---


Rendering
=========

UForm rendering is flexible. It was designed to allow maximum customization.
The render process uses [twig](http://twig.sensiolabs.org/).




Built-in engines
----------------

- [Bootstrap 3](./Bootstrap3.md)
- [Foundation 5](./Foundation5.md)


Implement your own rendering
============================

You can implement your own rendering in order to **add new components** or to **customize the rendering**
or to **implement a new client framework**. This can be achieved by either starting from scratch or extending
an existing engine.

**When should I write it from scratch?** - You should write it from scratch if you write for a specific framework

**When should I extend an engine?** - You should extend an engine if an engine already fits most of your needing,
but you need new inputs, new structure or to customize existing elements.

Extend an existing render engine
--------------------------------

When extending an existing render engine you take all existing templates from this engine and you can override some
of them with yours or add custom templates from a given template directory.

This is achieved by extending a class that already extends the ``AbstractHtmlRender`` and modifying 
the output of a method:

```php
class MyEngine extends BaseEngineToExtend {

    public function getTemplatesPaths()
    {
        return [__DIR__ . '/path/to/my/engine/directory'] 
            + parent::getTemplatesPaths();
    }
 
    public function getRenderName()
    {
        return "NameOfMyEngine";
    }
}
```

In this example the directory ``__DIR__ . '/path/to/my/engine/directory'`` will contain the template 
of you render engine.




Base rendering class
--------------------

A render engine must extend the class ``UForm\Render\AbstractHtmlRender``


Rendering templates
-------------------

Templates are written with twig. The name of the templates matches the [semantic types](#element-semantic-types) of the element.
If a semantic type does not have a template, the next semantic type is checked, until one matches.
If any of the semantic type has a matching template then an exception is thrown.

### Template variables

- **current**: the instance of the current ``RenderContext`` instance
- **current.element**: the instance of the element you are rendering
- **current.children**: an array with the instances of the children of the current element
- **current.messages**: an array with the error messages for the current element
- **render**: the instance of the render engine

### Template functions

- **renderElement(element)**: process to the render of the given element
- **renderParentType()**: continue the rendering of the current element with the next semantic types
e.g if you call this during the rendering of a ``form`` it will process to the rendering of the form as a ``group``
- **defaultRenderFor()**: process to the default rendering of an element implementing ``UForm\Element\Drawable``
- **isValid()**: check if the current element is valid
- **isValid(element)**: check if the given element is valid
- **childrenAreValid()**: check if the children of the current element are valid
- **childrenAreValid(element)**: check if the children of the given element are valid

Element Semantic types
----------------------

Each element has one or more semantic types. Semantic types help to render the element. 

For instance an ``input text`` has the following semantic types:

- ``input:text``
- ``input:textfield`` (common to input text, password, url, email...)
- ``input`` (common to all input elements)
- ``primary`` (common to input, select, textarea)
- ``element`` (common to **ALL** elements)

The order is very important for the rendering because the engine will try all the types in this order
to find a template matching the name in the template directory. 

In this example it will use the first file found in this list:

- ``input:text.twig``
- ``input:textfield.twig``
- ``input.twig``
- ``primary.twig``
- ``element.twig``

Element Options
---------------

Each element has standard options that engines **must** take care of.

Options can be ``label``, ``placeholder``, ``helper``, ``tooltip``, ``leftAddon``...
 
In this example we render the ``label`` of an element:

```twig
{% if current.element.getOption("label") %}
    <label for="{{ current.element.getId() }}">{{ current.element.getOption("label") }}</label>
{% endif %}
```


Notice about accessibility
--------------------------

We highly encourage every implementation of render engine to take care accessibility.

Thus the following rules should be considered:

- Always make use of ``label``
- Always link ``label`` to ``input`` with ``for`` attribute
- Always link ``label`` with attribute ``aria-labelledby``
- If an helper is present you should link it with ``aria-describedby``
