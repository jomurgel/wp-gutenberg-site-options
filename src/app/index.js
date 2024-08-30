import { createRoot, StrictMode } from '@wordpress/element';
import SiteOptions from './components/site-options';
import './styles/overrides.scss';

const rootElement = document.getElementById('wp-gutenberg-site-options');
const root = createRoot(rootElement);

root.render(
  <StrictMode>
    <SiteOptions />
  </StrictMode>
);
