import { __ } from '@wordpress/i18n';
import { __experimentalNumberControl as NumberControl, Spinner, TextControl } from '@wordpress/components';
import useSiteOptions from "../../hooks/use-site-options";
import Notices from '../notices';

const SiteOptions = () => {
  const [{ loading, saving, settings }, setOptions] = useSiteOptions();

  const {
    title,
    posts_per_page: postsPerPage,
  } = settings || {}

  return (
    <div>
      <Notices />

      <h1>{__('Gutenberg-powered Site Options', 'wp-gutenberg-site-options')}</h1>

      <TextControl
        label={__('Title', 'wp-gutenberg-site-options')}
        value={title}
        onChange={(next) => setOptions({ title: next })}
      />

      <NumberControl
        label={__('Posts Per Page', 'wp-gutenberg-site-options')}
        onChange={(next) => setOptions({ posts_per_page: next })}
        shiftStep={1}
        min={1}
        max={100}
        value={postsPerPage}
      />

      <div class="wp-gso__doing-things">{loading || saving ? <Spinner /> : null}</div>
    </div>
  )
}

export default SiteOptions;
