<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Raymond J. Kolbe <raymond.kolbe@maine.edu>
 * @copyright Copyright (c) 2012 University of Maine
 * @license	http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace DOMPDFModule\View\Renderer;

use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\ResolverInterface as Resolver;
use \DOMPDF;

class PdfRenderer implements Renderer
{
    private $paperSize = '8x11';
    private $paperOrientation = 'portrait';
    private $basePath = '/';
    private $fileName = null;
    private $resolver = null;
    private $htmlRenderer = null;
    
    public function setHtmlRenderer(Renderer $renderer)
    {
        $this->htmlRenderer = $renderer;
        return $this;
    }
    
    public function getHtmlRenderer()
    {
        return $this->htmlRenderer;
    }
    
    public function setPaperSize($size)
    {
        $this->paperSize = $size;
        
        return $this;
    }
    
    public function setPaperOrientation($orientation)
    {
        $this->paperOrientation = $orientation;
        
        return $this;
    }
    
    public function setBasePath($path)
    {
        $this->path = $path;
        
        return $this;
    }
    
    public function setFileName($name)
    {
        $this->fileName = $name;
        
        return $this;
    }
    
    public function getFileName()
    {
        return $this->fileName;
    }
    
    /**
     * Renders values as a PDF
     *
     * @param  string|Model $name The script/resource process, or a view model
     * @param  null|array|\ArrayAccess Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        $html = $this->getHtmlRenderer()->render($nameOrModel, $values);
        
        $pdf = new DOMPDF();
        $pdf->set_paper($this->paperSize, $this->paperOrientation);
        $pdf->set_base_path($this->basePath);
        
        $pdf->load_html($html);
        $pdf->render();

        return $pdf->output();
    }

    public function getEngine()
    {
        return $this;
    }

    public function setResolver(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }
}
