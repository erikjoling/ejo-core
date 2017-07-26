# EJO Core

## Self: Put functionality in the framework or not?
Functionality shouldn't break when changing theme. Keep in mind that not every theme has ejocore included.

So Shortcodes, Sitescripts and Social Media should be placed in the plugin domain.. That way other themes can make use of the content.

New plugin called EJOpack?

This means I will have EJOcore as an dropin framework for my custom themes, EJOpack as a plugin for site-utilities and EJObase as a MU-plugin for my basewebsite concept. That seems managable.

For now I first want to finish EJOcore before I extract functionality to the EJOpack plugin.